<?php
namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use App\Http\Requests\Payment\PayWithStripeRequest;
use App\Models\Order;
use Stripe\Charge;
use Stripe\Stripe;
use Stripe\Token;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Throwable;
use Illuminate\Support\Facades\Gate;
use SM\Factory\FactoryInterface;
use App\Util\PaymentStatuses;
use App\Http\Resources\Order\NewOrderResource;

class StripeController extends Controller
{
    
    private FactoryInterface $smFactory;
    
    public function __construct(FactoryInterface $smFactory)
    {
        $this->smFactory = $smFactory;
    }

    public function pay(PayWithStripeRequest $request, $id)
    {
        try {
            $order = Order::findOrFail($id);
            Gate::authorize('update', $order);
            
            $orderStateMachine = $this->smFactory->get($order, 'checkout');
            
            Stripe::setApiKey(config('app.stripe_key'));
            
            $orderStateMachine->apply('attempt_payment');
            
            $token = Token::create([
                'card' => [
                    'number' => $request['number'],
                    'cvc' => $request['cvc'],
                    'exp_month' => $request['exp_month'],
                    'exp_year' => $request['exp_year']
                ]
            ]);

            $charge = Charge::create([
                'amount' => $order->total->getIntegerValue(),
                'currency' => $order->total->currency,
                'source' => $token->id,
                'description' => 'Payment for order '.$order->order_number
            ]);

            if (! $charge instanceof Charge) {
                throw new BadRequestHttpException("Something went wrong. Please try again");
            }
            
            if($charge->status === PaymentStatuses::$STRIPE_SUCCESS){
                $orderStateMachine->apply('successful_payment');
                $order->payment_status = PaymentStatuses::$SUCCESSFUL;
            }
            
            if($charge->status === PaymentStatuses::$STRIPE_FAILED){
                $orderStateMachine->apply('failed_payment');
                $order->payment_status = PaymentStatuses::$FAILED;
            }
            
            $order->save();
            
            return (new NewOrderResource($order))->response()->setStatusCode(200);
        } catch (Throwable $e) {
            throw new BadRequestHttpException($e->getMessage());
        }
    }
}
