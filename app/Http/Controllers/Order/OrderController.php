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
use Throwable;
use App\Models\RightsBundle;
use App\Http\Resources\Order\NewOrderResource;
use Database\Factories\OrderFactory;
use App\Helper\CurrencyExchange;

class OrderController extends Controller
{

    private FactoryInterface $smFactory;
    
    public function __construct(FactoryInterface $smFactory){
       $this->smFactory = $smFactory;
    }
    
    public function index(Request $request)
    {
        Gate::authorize('viewAny', Order::class);
        
        $orders = SearchFormatter::getSearchQueries($request, Order::class);

        $orders = $orders->with('total:value,currency', 'rights_bundle:id,product_id', 'rights_bundle.product:id,title');

        $orders = $orders->select([
            'id',
            'order_number',
            'state',
            'created_at'
        ]);

        $orders = $orders->paginate($request->input('per_page'));

        return CollectionResource::make($orders);
    }

    public function store(Request $request)
    {
        Gate::authorize('create', Order::class);
        try {
            $rightsBundle = RightsBundle::findOrFail($request->get('rights_bundle_id'));
            $buyerUser = $this->user();
            $order = OrderFactory::createNewOrder($buyerUser, $rightsBundle);
            
            return (new NewOrderResource($order))->response()->setStatusCode(201);
        } catch (Throwable $e) {
            DB::rollback();
            throw new BadRequestHttpException($e->getMessage());
        }
    }
    
    public function changeCurrency(ExchangeOrderCurrencyRequest $request, $id)
    {
        $order = Order::findOrFail($id);
        Gate::authorize('update', $order);
        
        try {
            $toCurrency =  $request['pay_in_currency'];
            
            $order->pay_in_currency = $toCurrency;
            $order->exchange_rate = CurrencyExchange::getExchangeRate($order->price->currency, $toCurrency);
            
            CurrencyExchange::getExchangedMoney($order->price, $toCurrency);
            CurrencyExchange::getExchangedMoney($order->vat, $toCurrency);
            CurrencyExchange::getExchangedMoney($order->total, $toCurrency);
            
            return (new NewOrderResource($order))->response()->setStatusCode(200);
        } catch (Throwable $e) {
            DB::rollback();
            throw new BadRequestHttpException($e->getMessage());
        }
    }
    
    public function updateContractStatus(UpdateContractStatusRequest $request, $id)
    {
        $order = Order::findOrFail($id);
        Gate::authorize('update', $order);
        
        try {
            $contractAccepted =  $request['accept_contract'];
            $orderStateMachine = $this->smFactory->get($order, 'checkout');
            
            if($contractAccepted){
                $orderStateMachine->apply('accept_contract');
            }else{
                $orderStateMachine->apply('deny_contract');
            }
            
            return (new NewOrderResource($order))->response()->setStatusCode(200);
        } catch (Throwable $e) {
            DB::rollback();
            throw new BadRequestHttpException($e->getMessage());
        }
    }

    public function show(Order $order)
    {
        Gate::authorize('view', $order);
        return (new NewOrderResource($order));
    }

    public function update(Request $request, Order $order)
    {
        //
    }

    public function destroy(Order $order)
    {
        //
    }
}
