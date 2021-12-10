<?php
namespace App\Http\Resources\Order;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Organisation;
use App\Models\RightsBundle;
use App\Http\Resources\Resource;
use App\Models\Product;
use App\Models\Money;
use App\Models\Percentage;

class NewOrderResource extends JsonResource
{
    public function toArray($request)
    {
        $this->makeVisible(['state']);
        
        $order = parent::toArray($request);
        if (isset($order[0])) {
            $order = $order[0];
        }
        
        if (isset($order['organisation_id'])) {
            unset($order['organisation_id']);
        }
        
        if (isset($order['organisation'])) {
            unset($order['organisation']);
        }
        
        if (isset($order['buyer_user_id'])) {
            unset($order['buyer_user_id']);
        }
        
        if (isset($order['rights_bundle_id'])) {
            $rightsBundle = RightsBundle::where('id', $order['rights_bundle_id'])->first();
            $rightsBundleResponse = new Resource($rightsBundle);
            
            if (isset($rightsBundleResponse[0])) {
                $rightsBundleResponse = $rightsBundleResponse[0];
            }
            
            if(isset($rightsBundleResponse['price_id'])){
                unset($rightsBundleResponse['price_id']);
            }
            
            if(isset($rightsBundleResponse['product_id'])){
                $product = Product::where('id', $rightsBundleResponse['product_id'])->first();
                $productResponse = [];
                $productResponse['title'] = $product->title;
                $image = $product->marketing_assets->key_artwork;
                $productResponse['marketing_assets']['key_artwork']['image']['id'] = $image->id;
                $productResponse['marketing_assets']['key_artwork']['image']['image_name'] = $image->image_name;
                $productResponse['marketing_assets']['key_artwork']['image']['image_url'] = $image->image_url;
                $productResponse['marketing_assets']['key_artwork']['image']['image_name'] = $image->image_name;
                $productResponse['marketing_assets']['key_artwork']['image']['mime'] = $image->mime;

                $rightsBundleResponse['product'] = $productResponse;
            }
            
            $bundleRightsInformation = $rightsBundle->bundle_rights_information()->get();
            
            $rightsInfoResponse = [];
            foreach ($bundleRightsInformation as $rightsInformation) {
                
                $rightsInfoSingleResponse = [];
                $rightsInfoSingleResponse['title'] = $rightsInformation->title;
                $rightsInfoSingleResponse['short_description'] = $rightsInformation->short_description;
                $rightsInfoSingleResponse['long_description'] = $rightsInformation->long_description;
                
                $rightsInfoResponse[] = $rightsInfoSingleResponse;
            }
            
            $rightsBundleResponse['rights_information'] = $rightsInfoResponse;
            
            $order['rights_bundle'] = $rightsBundleResponse;
        }
        
        if(isset($order['price_id'])){
            $price = Money::where('id', $order['price_id'])->first();
            $priceResponse = new Resource($price);
            $order['price'] = $priceResponse;
        }
        
        if(isset($order['total_id'])){
            $total = Money::where('id', $order['total_id'])->first();
            $totalResponse = new Resource($total);
            $order['total'] = $totalResponse;
        }
        
        if(isset($order['vat_percentage_id'])){
            $vat = Percentage::where('id', $order['vat_percentage_id'])->first();
            $vatResponse = new Resource($vat);
            $order['vat_percentage'] = $vatResponse;
        }
        
        if(isset($order['vat_id'])){
            $vat = Money::where('id', $order['vat_id'])->first();
            $vatResponse = new Resource($vat);
            $order['vat'] = $vatResponse;
        }
        
        return $order;
    }
}

