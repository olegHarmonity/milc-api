<?php
namespace Database\Factories;

use App\Models\Order;
use App\Models\User;
use App\Util\CartStates;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\RightsBundle;
use App\Models\Percentage;
use App\Models\VatRule;
use App\Util\VatRuleNames;

class OrderFactory extends Factory
{

    protected $model = Order::class;

    public function definition()
    {
        return [];
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

        do {
            $orderNumber = self::generateOrderNumber();
        } while (Order::where('order_number', 'LIKE', $orderNumber)->first() != null);

        $order->order_number = $orderNumber;

        $order->organisation_id = $organisation->id;
        $order->buyer_user_id = $buyerUser->id;
        $order->rights_bundle_id = $rightsBundle->id;

        $priceFromBundle = $rightsBundle->price()->first();

        $price = MoneyFactory::createMoney($priceFromBundle->value, $priceFromBundle->currency);
        $price->save();
        
        /*
         * todo: uncomment
        $seller = $rightsBundle->product->organisation;
        $buyerCountry = $organisation->country;
        $vatRules = $seller->vat_rules;
        $vatPercentValue = null;
        
        foreach ($vatRules as $vatRule){
            if($vatRule->rule_type === VatRuleNames::$INTERNATIONAL_OTHER){
                $vatPercentValue = $vatRule->vat->value;
                continue;
            }
            
            if($vatRule->country === $buyerCountry){
                $vatPercentValue = $vatRule->vat->value;
                break;
            }
        }
       
        $vatPercentage = PercentageFactory::createPercentage($vatPercentValue);
        */
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

    public static function generateOrderNumber()
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < 9; $i ++) {

            if ($i < 4) {
                $randomString .= rand(0, 9);
                continue;
            }

            if ($i === 4) {
                $randomString .= '-';
                continue;
            }

            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}
