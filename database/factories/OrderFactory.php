<?php
namespace Database\Factories;

use App\Models\Order;
use App\Models\User;
use App\Util\CartStates;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\RightsBundle;

class OrderFactory extends Factory
{

    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Order::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [ //
        ];
    }

    public static function createNewOrder(User $buyerUser, RightsBundle $rightsBundle)
    {
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
        if ($latestOrder) {
            $order->order_number = '#' . str_pad($latestOrder->id + 1, 8, "0", STR_PAD_LEFT);
        } else {
            $order->order_number = '#' . str_pad(1, 8, "0", STR_PAD_LEFT);
        }

        $order->organisation_id = $organisation->id;
        $order->buyer_user_id = $buyerUser->id;
        $order->rights_bundle_id = $rightsBundle->id;

        $priceFromBundle = $rightsBundle->price()->first();

        $price = MoneyFactory::createMoney($priceFromBundle->value, $priceFromBundle->currency);
        $price->save();

        $vatPercentage = PercentageFactory::createPercentage(20);
        $vatPercentage->save();

        $vat = $price->calculate_percentage($vatPercentage);
        $vat->save();

        $total = $price->sum_up_money($vat);
        $total->save();

        $order->price_id = $price->id;
        $order->total_id = $total->id;
        $order->vat_percentage_id = $vatPercentage->id;
        $order->vat_id = $vat->id;

        $order->save();
        
        return $order;
    }
}