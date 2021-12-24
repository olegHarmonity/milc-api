<?php
namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use App\Http\Requests\Payment\PayWithPaypalRequest;
use App\Models\Order;
use App\Util\PaymentStatuses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Mail;
use Omnipay\Omnipay;
use Throwable;
use SM\Factory\FactoryInterface;
use Omnipay\Common\GatewayInterface;
use App\Http\Resources\Order\NewOrderResource;
use App\Util\PaymentMethods;
use Illuminate\Support\Facades\Redirect;
use App\Mail\OrderPaidEmail;

class PayPalController extends Controller
{

    private GatewayInterface $gateway;

    private FactoryInterface $smFactory;

    private string $webAppUrl;

    public function __construct(FactoryInterface $smFactory)
    {
        $this->smFactory = $smFactory;
        $this->gateway = Omnipay::create('PayPal_Rest');
        $this->gateway->setClientId(config('app.paypal_client_id'));
        $this->gateway->setSecret(config('app.paypal_client_secret'));
        $this->gateway->setTestMode(config('app.paypal_test_env'));
        $this->webAppUrl = config('app.web_url');
    }

    public function pay(PayWithPaypalRequest $request, $orderNumber)
    {
        $request->validated();

        $order = Order::where('order_number', 'LIKE', $orderNumber)->first();
        Gate::authorize('update', $order);

        $orderStateMachine = $this->smFactory->get($order, 'checkout');

        try {
            $orderStateMachine->apply('attempt_payment');
            $order->payment_method = PaymentMethods::$PAYPAL;
            $order->save();

            $total = $order->total;

            $response = $this->gateway->purchase([
                'amount' => $total->value,
                'currency' => $total->currency,
                'returnUrl' => $this->webAppUrl . 'app/checkout/' . $orderNumber . '/paypal-callback' ,
                'cancelUrl' => $this->webAppUrl . 'app/checkout/' . $orderNumber . '/paypal-callback/cancel'
            ])->send();


            if ($response->isRedirect()) {
                $redirectLink = "";
                $responseData = $response->getData();

                if(isset($responseData['links'])){
                    foreach ($responseData['links'] as $linkInfo){
                        if($linkInfo['method'] == 'REDIRECT'){
                            $redirectLink = $linkInfo['href'];
                        }
                    }
                }

                return response()->json([
                    'redirect_link' => $redirectLink
                ]);

            } else {

                $orderStateMachine->apply('failed_payment');
                $order->payment_status = PaymentStatuses::$FAILED;
                $order->save();
                return $response->getMessage();
            }
        } catch (Throwable $e) {

            $orderStateMachine->apply('failed_payment');
            $order->payment_status = PaymentStatuses::$FAILED;
            $order->save();
            return $e->getMessage();
        }

        // return (new NewOrderResource($order))->response()->setStatusCode(200);
    }

    public function paymentSuccess(Request $request, $orderNumber)
    {
        $order = Order::where('order_number', 'LIKE', $orderNumber)->first();
        Gate::authorize('update', $order);

        $orderStateMachine = $this->smFactory->get($order, 'checkout');

        if ($request->input('paymentId') && $request->input('PayerID')) {

            $transaction = $this->gateway->completePurchase(array(
                'payer_id' => $request->input('PayerID'),
                'transactionReference' => $request->input('paymentId')
            ));

            $response = $transaction->send();

            if ($response->isSuccessful()) {
                $paypalResponse = $response->getData();

                if ($paypalResponse['state'] === PaymentStatuses::$PAYPAL_APPROVED) {
                    $orderStateMachine->apply('successful_payment');
                    $order->payment_status = PaymentStatuses::$SUCCESSFUL;
                    $order->transaction_id = $paypalResponse['id'];
                    $order->save();
                    
                    Mail::to($order->delivery_email)->send(new OrderPaidEmail($order->organisation_name, $order->order_number));
                }
                return (new NewOrderResource($order))->response()->setStatusCode(200);
            } else {
                $orderStateMachine->apply('failed_payment');
                $order->payment_status = PaymentStatuses::$FAILED;
                $order->save();

                return (new NewOrderResource($order))->response()->setStatusCode(200);
            }
        } else {
            $orderStateMachine->apply('failed_payment');
            $order->payment_status = PaymentStatuses::$FAILED;
            $order->save();
            return (new NewOrderResource($order))->response()->setStatusCode(200);
        }
    }

    public function paymentError(Request $request, $orderNumber)
    {
        $order = Order::where('order_number', 'LIKE', $orderNumber)->first();
        Gate::authorize('update', $order);

        $orderStateMachine = $this->smFactory->get($order, 'checkout');
        $orderStateMachine->apply('failed_payment');
        $order->payment_status = PaymentStatuses::$CANCELLED;
        $order->save();

        return (new NewOrderResource($order))->response()->setStatusCode(200);
    }
}
