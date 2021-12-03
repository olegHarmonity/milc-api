<?php
namespace App\Http\Controllers\Order;

use App\Helper\SearchFormatter;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use App\Http\Controllers\Controller;
use App\Http\Resources\CollectionResource;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Throwable;
use App\Models\RightsBundle;
use App\Http\Resources\Resource;
use App\Models\Money;
use App\Models\Percentage;
use App\Http\Resources\Order\NewOrderResource;
use App\Util\CartStates;

class OrderController extends Controller
{

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
            $organisation = $buyerUser->organisation()->first();
            $organisationOwner = $organisation->organisation_owner()->first();
            $organisationType = $organisation->organisation_type()->first();

            $order = new Order();

            $order->contact_email = $organisation->email;
            $order->delivery_email = $organisation->email;
            $order->organisation_name = $organisation->organisation_name;
            $order->organisation_type = $organisationType->name;
            $order->organisation_email = $organisation->email;
            $order->organisation_phone = $organisation->phone_number;
            $order->organisation_address = $organisation->address . ", " . $organisation->postal_code . " " . $organisation->city;
            $order->organisation_registration_number = $organisation->registration_number;
            $order->billing_first_name = $organisationOwner->first_name;
            $order->billing_last_name = $organisationOwner->last_name;
            $order->billing_email = $organisationOwner->email;
            $order->billing_address = $organisationOwner->address . ", " . $organisationOwner->postal_code . " " . $organisationOwner->city;
            $order->state = CartStates::$NEW;
            
            $latestOrder = Order::OrderBy('created_at', 'DESC')->first();
            if ($latestOrder){
                $order->order_number = '#' . str_pad($latestOrder->id + 1, 8, "0", STR_PAD_LEFT);
            }else{
                $order->order_number = '#' . str_pad(1, 8, "0", STR_PAD_LEFT);
            }

            $order->organisation_id = $organisation->id;
            $order->buyer_user_id = $buyerUser->id;
            $order->rights_bundle_id = $rightsBundle->id;

            $priceFromBundle = $rightsBundle->price()->first();

            $price = new Money();
            $price->value = $priceFromBundle->value;
            $price->currency = $priceFromBundle->currency;
            $price->save();

            $total = new Money();
            $total->value = $priceFromBundle->value;
            $total->currency = $priceFromBundle->currency;
            $total->save();

            $vat = new Percentage();
            $vat->value = 0;
            $vat->save();

            $order->price_id = $price->id;
            $order->total_id = $total->id;
            $order->vat_id = $vat->id;

            $order->save();
            
            return (new NewOrderResource($order))->response()->setStatusCode(201);
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

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Order $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Order $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        //
    }
}
