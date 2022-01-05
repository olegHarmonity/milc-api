<?php
namespace App\DataTransformer\Product;

use App\Models\Money;
use App\Models\RightsBundle;
use Illuminate\Support\Facades\DB;
use App\Models\Product;
use App\Util\NotificationCategories;
use Database\Factories\NotificationFactory;

class UpdateRightsBundlesDataTransformer
{

    public static function transformData($arrayRequest, RightsBundle $bundleRight)
    {
        DB::beginTransaction();

        if (isset($arrayRequest['rights_information'])) {
            $rightsBundlesRightsInfoRequest = $arrayRequest['rights_information'];
            unset($arrayRequest['rights_information']);
        }

        $priceRequest = [];
        if (isset($arrayRequest['price'])) {
            $priceRequest = $arrayRequest['price'];
            unset($arrayRequest['price']);
        }

        if (isset($priceRequest['id'])) {
            $price = Money::findOrFail($priceRequest['id']);
            $price->update($priceRequest);
        } else {
            $price = Money::create($priceRequest);
        }

        $price->save();

        $arrayRequest['price_id'] = $price->id;

        $bundleRight->update($arrayRequest);

        if (isset($rightsBundlesRightsInfoRequest)) {
            $bundleRight->bundle_rights_information()->detach();

            foreach ($rightsBundlesRightsInfoRequest as $rightsBundlesRightInfoRequest) {
                $bundleRight->bundle_rights_information()->attach($rightsBundlesRightInfoRequest);
            }
        }

        $bundleRight->save();

        $product = $bundleRight->product;

        $product->rights_bundles()->attach($bundleRight->id);
        $product->save();

        if ($bundleRight->buyer_id) {
            NotificationFactory::createNotification("Custom rights bundle created for you", "A custom rights bundle was created for your organisation for product " . $product->title . ". To see the custom bundle, go to product view page.", NotificationCategories::$OTHER, $bundleRight->buyer_id);
        }
        
        DB::commit();

        return $product;
    }
}

