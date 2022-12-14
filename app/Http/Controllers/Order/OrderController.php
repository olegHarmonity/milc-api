<?php
namespace App\Http\Controllers\Order;

use App\Helper\SearchFormatter;
use SM\Factory\FactoryInterface;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Order\ExchangeOrderCurrencyRequest;
use App\Http\Requests\Order\UpdateContractStatusRequest;
use App\Http\Resources\CollectionResource;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Mail;
use Throwable;
use App\Models\RightsBundle;
use App\Http\Resources\Order\NewOrderResource;
use Database\Factories\OrderFactory;
use App\Helper\CurrencyExchange;
use App\Util\PaymentMethods;
use App\Util\PaymentStatuses;
use App\Mail\ContractAcceptedBuyerEmail;
use App\Mail\ContractAcceptedSellerEmail;
use App\Models\GeneralAdminSettings;
use App\Mail\BankTransferInitEmail;
use App\Mail\AssetsSentEmail;
use App\Mail\AssetsReceivedEmail;
use App\Mail\OrderCompleteEmail;
use App\Mail\OrderRejectedEmail;
use App\Mail\OrderCancelledEmail;
use App\Mail\OrderRefundedEmail;
use App\Mail\OrderPaidEmail;
use Database\Factories\NotificationFactory;
use App\Util\NotificationCategories;

class OrderController extends Controller
{

    private FactoryInterface $smFactory;

    public function __construct(FactoryInterface $smFactory)
    {
        $this->smFactory = $smFactory;
    }

    public function index(Request $request)
    {
        Gate::authorize('viewAny', Order::class);

        $user = $this->user();
        $ordersQuery = null;
        if (! $user->isAdmin()) {
            $ordersQuery = Order::where(function ($q) use ($user) {
                $q->where('organisation_id', $user->organisation->id)->orWhere('seller_id', $user->organisation->id);
            });
        }

        $orders = SearchFormatter::getSearchQueries($request, Order::class, $ordersQuery);

        $orders = $orders->with('price:id,value,currency', 'rights_bundle:id,product_id', 'rights_bundle.product:id,title,marketing_assets_id', 'rights_bundle.product.marketing_assets:id,key_artwork_id', 'rights_bundle.product.marketing_assets.key_artwork:id,image_name,image_url');

        $orders = $orders->select([
            'id',
            'order_number',
            'organisation_id',
            'seller_id',
            'organisation_name',
            'state',
            'created_at',
            'price_id',
            'rights_bundle_id'
        ]);

        $orders = $orders->paginate($request->input('per_page'));

        return CollectionResource::make($orders);
    }

    public function store(Request $request)
    {
        try {
            Gate::authorize('create', Order::class);

            $rightsBundle = RightsBundle::findOrFail($request->get('rights_bundle_id'));
            $buyerUser = $this->user();

            $order = OrderFactory::createNewOrder($buyerUser, $rightsBundle);

            return (new NewOrderResource($order))->response()->setStatusCode(201);
        } catch (Throwable $e) {
            DB::rollback();
            throw new BadRequestHttpException($e->getMessage());
        }
    }

    public function changeCurrency(ExchangeOrderCurrencyRequest $request, $orderNumber)
    {
      //  try {
            $order = Order::where('order_number', 'LIKE', $orderNumber)->first();
            Gate::authorize('update', $order);

            $toCurrency = $request['pay_in_currency'];

            $order->pay_in_currency = $toCurrency;
            $order->exchange_rate = CurrencyExchange::getExchangeRate($order->price->currency, $toCurrency);

            CurrencyExchange::getExchangedMoney($order->price, $toCurrency);
            CurrencyExchange::getExchangedMoney($order->vat, $toCurrency);
            CurrencyExchange::getExchangedMoney($order->total, $toCurrency);

            $order->save();

            return (new NewOrderResource($order))->response()->setStatusCode(200);
        /*} catch (Throwable $e) {
            DB::rollback();
            throw new BadRequestHttpException($e->getMessage());
        }*/
    }

    public function updateContractStatus(UpdateContractStatusRequest $request, $orderNumber)
    {
        try {
            $order = Order::where('order_number', 'LIKE', $orderNumber)->first();
            Gate::authorize('update', $order);

            $contractAccepted = $request['accept_contract'];
            $orderStateMachine = $this->smFactory->get($order, 'checkout');

            if ($contractAccepted) {
                $orderStateMachine->apply('accept_contract');
                $order->contract_accepted_at = new \DateTime();
                $order->contract_accepted = true;

                $contract = $order->contract;

                Mail::to($contract->buyer->email)->send(new ContractAcceptedBuyerEmail($contract->buyer->organisation_name, $order->order_number, $contract));

                Mail::to($contract->seller->email)->send(new ContractAcceptedSellerEmail($contract->seller->organisation_name, $order->order_number, $contract));

                NotificationFactory::createNotification("Order contract accepted", "The contract for your order no. " . $orderNumber . " has been accepted. To view or download it, go to your order view page.", NotificationCategories::$ORDER, $contract->buyer->id);
            } else {
                $orderStateMachine->apply('deny_contract');
            }

            $order->save();

            return (new NewOrderResource($order))->response()->setStatusCode(200);
        } catch (Throwable $e) {
            DB::rollback();
            throw new BadRequestHttpException($e->getMessage());
        }
    }

    public function payViaBankTransfer(Request $request, $orderNumber)
    {
        try {
            $order = Order::where('order_number', 'LIKE', $orderNumber)->first();
            Gate::authorize('update', $order);

            $orderStateMachine = $this->smFactory->get($order, 'checkout');

            $orderStateMachine->apply('attempt_payment');
            $order->payment_method = PaymentMethods::$BANK_TRANSFER;
            $order->payment_started_at = new \DateTime();

            $order->save();

            $bankInfo = GeneralAdminSettings::all()->first();

            if ($bankInfo) {
                Mail::to($order->delivery_email)->send(new BankTransferInitEmail($order->organisation_name, $order->order_number, $bankInfo->iban, $bankInfo->swift_bic, $bankInfo->bank_name));
                NotificationFactory::createNotification("Order payment started", "The payment for your order no. " . $orderNumber . " has been initiated. To view the order, go to your order view page.", NotificationCategories::$ORDER, $order->buyer_user->organisation->id);
            }

            return (new NewOrderResource($order))->response()->setStatusCode(200);
        } catch (Throwable $e) {
            DB::rollback();
            throw new BadRequestHttpException($e->getMessage());
        }
    }

    public function markAssetsAsSent(Request $request, $orderNumber)
    {
        try {
            $order = Order::where('order_number', 'LIKE', $orderNumber)->first();
            Gate::authorize('updateSeller', $order);

            $orderStateMachine = $this->smFactory->get($order, 'checkout');

            $orderStateMachine->apply('send_assets');
            $order->assets_sent_at = new \DateTime();

            $order->save();
            Mail::to($order->delivery_email)->send(new AssetsSentEmail($order->organisation_name, $order->order_number));
            NotificationFactory::createNotification("Assets sent for order", "Assets for your order no. " . $orderNumber . " have been marked as sent. To view or download them, go to your order view page.", NotificationCategories::$ORDER, $order->buyer_user->organisation->id);

            return (new NewOrderResource($order))->response()->setStatusCode(200);
        } catch (Throwable $e) {
            DB::rollback();
            throw new BadRequestHttpException($e->getMessage());
        }
    }

    public function markAssetsAsReceived(Request $request, $orderNumber)
    {
        try {
            $order = Order::where('order_number', 'LIKE', $orderNumber)->first();
            Gate::authorize('updateBuyer', $order);

            $orderStateMachine = $this->smFactory->get($order, 'checkout');

            $orderStateMachine->apply('receive_assets');
            $order->assets_received_at = new \DateTime();

            $order->save();

            $seller = $order->seller;
            Mail::to($seller->email)->send(new AssetsReceivedEmail($seller->organisation_name, $order->order_number));
            NotificationFactory::createNotification("Order paid", "Your order no. " . $orderNumber . " has been marked as paid. To view the order, go to your order view page.", NotificationCategories::$ORDER, $seller->id);

            return (new NewOrderResource($order))->response()->setStatusCode(200);
        } catch (Throwable $e) {
            DB::rollback();
            throw new BadRequestHttpException($e->getMessage());
        }
    }

    public function markAsCompleted(Request $request, $orderNumber)
    {
        try {
            $order = Order::where('order_number', 'LIKE', $orderNumber)->first();
            Gate::authorize('updateSeller', $order);

            $orderStateMachine = $this->smFactory->get($order, 'checkout');

            $orderStateMachine->apply('complete');
            $order->completed_at = new \DateTime();

            $order->save();

            Mail::to($order->delivery_email)->send(new OrderCompleteEmail($order->organisation_name, $order->order_number, $order));
            NotificationFactory::createNotification("Order complete", "Your order no. " . $orderNumber . " has been marked as completed. To view the order, go to your order view page.", NotificationCategories::$ORDER, $order->buyer_user->organisation->id);

            return (new NewOrderResource($order))->response()->setStatusCode(200);
        } catch (Throwable $e) {
            DB::rollback();
            throw new BadRequestHttpException($e->getMessage());
        }
    }

    public function markAsRejected(Request $request, $orderNumber)
    {
        try {
            $order = Order::where('order_number', 'LIKE', $orderNumber)->first();
            Gate::authorize('updateSeller', $order);

            $orderStateMachine = $this->smFactory->get($order, 'checkout');

            $orderStateMachine->apply('reject');
            $order->rejected_at = new \DateTime();

            $order->save();

            Mail::to($order->delivery_email)->send(new OrderRejectedEmail($order->organisation_name, $order->order_number));
            NotificationFactory::createNotification("Order rejected", "Your order no. " . $orderNumber . " has been marked as rejected. To view the order, go to your order view page.", NotificationCategories::$ORDER, $order->buyer_user->organisation->id);

            return (new NewOrderResource($order))->response()->setStatusCode(200);
        } catch (Throwable $e) {
            DB::rollback();
            throw new BadRequestHttpException($e->getMessage());
        }
    }

    public function markAsCancelled(Request $request, $orderNumber)
    {
        try {
            $order = Order::where('order_number', 'LIKE', $orderNumber)->first();
            Gate::authorize('updateBuyer', $order);

            $orderStateMachine = $this->smFactory->get($order, 'checkout');

            $orderStateMachine->apply('cancel');
            $order->cancelled_at = new \DateTime();

            $order->save();

            Mail::to($order->delivery_email)->send(new OrderCancelledEmail($order->organisation_name, $order->order_number));
            NotificationFactory::createNotification("Order cancelled", "Your order no. " . $orderNumber . " has been marked as cancelled. To view the order, go to your order view page.", NotificationCategories::$ORDER, $order->buyer_user->organisation->id);

            return (new NewOrderResource($order))->response()->setStatusCode(200);
        } catch (Throwable $e) {
            DB::rollback();
            throw new BadRequestHttpException($e->getMessage());
        }
    }

    public function markAsRefunded(Request $request, $orderNumber)
    {
        try {
            $order = Order::where('order_number', 'LIKE', $orderNumber)->first();

            Gate::authorize('updateSeller', $order);

            $orderStateMachine = $this->smFactory->get($order, 'checkout');

            $orderStateMachine->apply('refund');
            $order->refunded_at = new \DateTime();

            $order->save();

            Mail::to($order->delivery_email)->send(new OrderRefundedEmail($order->organisation_name, $order->order_number));
            NotificationFactory::createNotification("Order refunded", "Your order no. " . $orderNumber . " has been marked as refunded. To view the order, go to your order view page.", NotificationCategories::$ORDER, $order->buyer_user->organisation->id);

            return (new NewOrderResource($order))->response()->setStatusCode(200);
        } catch (Throwable $e) {
            DB::rollback();
            throw new BadRequestHttpException($e->getMessage());
        }
    }

    public function markAsPaid(Request $request, $orderNumber)
    {
        try {
            $order = Order::where('order_number', 'LIKE', $orderNumber)->first();

            Gate::authorize('updateSeller', $order);

            $orderStateMachine = $this->smFactory->get($order, 'checkout');

            if ($order->payment_method === PaymentMethods::$BANK_TRANSFER) {
                $orderStateMachine->apply('successful_payment');
                $order->payment_status = PaymentStatuses::$SUCCESSFUL;
                $order->paid_at = new \DateTime();
                $order->save();
                Mail::to($order->delivery_email)->send(new OrderPaidEmail($order->organisation_name, $order->order_number));
                NotificationFactory::createNotification("Order paid", "Your order no. " . $orderNumber . " has been marked as paid. To view the order, go to your order view page.", NotificationCategories::$ORDER, $order->buyer_user->organisation->id);
            } else {
                throw new BadRequestHttpException("Only bank transfers can be marked as paid");
            }

            $order->save();

            return (new NewOrderResource($order))->response()->setStatusCode(200);
        } catch (Throwable $e) {
            DB::rollback();
            throw new BadRequestHttpException($e->getMessage());
        }
    }

    public function show(Request $request, $id)
    {
        $order = Order::findOrFail($id);

        Gate::authorize('view', $order);

        return (new NewOrderResource($order));
    }

    public function showCheckoutOrder(Request $request, $orderNumber)
    {
        $order = Order::where('order_number', 'LIKE', $orderNumber)->first();

        Gate::authorize('view', $order);

        return (new NewOrderResource($order));
    }
}
