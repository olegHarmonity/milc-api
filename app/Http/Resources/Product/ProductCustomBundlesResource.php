<?php
namespace App\Http\Resources\Product;

use App\Http\Resources\Resource;
use App\Models\MarketingAssets;
use App\Models\MovieContentType;
use App\Models\Product;
use App\Models\ProductionInfo;
use App\Models\Video;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Money;

class ProductCustomBundlesResource extends JsonResource
{
    public function toArray($request)
    {
        $user = auth()->user();
        $product = parent::toArray($request);  
        
        $productFromDb = Product::findOrFail($product['id']);
        
        $bundleRights = $productFromDb->rights_bundles()->get();
        foreach ($bundleRights as $bundleRight) {
            
            if($bundleRight->buyer_id === null){
                continue;
            }
            
            if(!$user->isAdmin() and $bundleRight->buyer_id !== $user->organisation_id){
                continue;
            }
            
            $bundleResourceResponse = new Resource($bundleRight);
            
            if (isset($bundleResourceResponse['price_id'])) {
                $price = Money::where('id', $bundleResourceResponse['price_id'])->first();
                $bundleResourceResponse['price'] = new Resource($price);
            }
            
            $rightsInformationArray = [];
            $rightsInformations = $bundleRight->bundle_rights_information()->get();
            foreach ($rightsInformations as $rightsInformation) {
                $rightsInformationArray[] = new Resource($rightsInformation);
            }
            
            $bundleResourceResponse['rights_information'] = $rightsInformationArray;
            
            $product['bundle_rights'][] = $bundleResourceResponse;
        }
        
        $rightsInformations = $productFromDb->available_formats()->get();
        foreach ($rightsInformations as $availableFormat) {
            $product['available_formats'][] = new Resource($availableFormat);
        }
        
        $genres = $productFromDb->genres()->get();
        foreach ($genres as $price) {
            $product['genres'][] = new Resource($price);
        }
        
        $dubFiles = $productFromDb->dub_files()->get();
        foreach ($dubFiles as $dubFile) {
            $product['dub_files'][] = new Resource($dubFile);
        }
        
        $subtitles = $productFromDb->subtitles()->get();
        foreach ($subtitles as $subtitle) {
            $product['subtitles'][] = new Resource($subtitle);
        }
        
        $promotionalVideos = $productFromDb->promotional_videos()->get();
        foreach ($promotionalVideos as $promotionalVideo) {
            $product['promotional_videos'][] = new Resource($promotionalVideo);
        }
        
        $rightsInformation = $productFromDb->rights_information()->get();
        foreach ($rightsInformation as $rightsInformationItem) {
            
            $rightsInformationResource = new Resource($rightsInformationItem);;
            
            $availableRights = $rightsInformationItem->available_rights()->get();
            $availableRightsArray = [];
            foreach ($availableRights as $availableRight) {
                $availableRightsArray[] = new Resource($availableRight);
            }
            
            $rightsInformationResource['available_rights'] = $availableRightsArray;
            $product['rights_information'][] = $rightsInformationResource;
        }
        
        if (isset($product['content_type_id'])) {
            $contentType = MovieContentType::where('id', $product['content_type_id'])->first();
            $product['content_type'] = new Resource($contentType);
        }
        
        if (isset($product['production_info_id'])) {
            $productionInfo = ProductionInfo::where('id', $product['production_info_id'])->first();
            
            $directors = $productionInfo->directors()->get();
            $directorsArray = [];
            foreach ($directors as $director) {
                $directorsArray[] = new Resource($director);
            }
            
            $productionInfo['directors'] = $directorsArray;
            
            $producers = $productionInfo->producers()->get();
            $producersArray = [];
            foreach ($producers as $producer) {
                $producersArray[] = new Resource($producer);
            }
            
            $productionInfo['producers'] = $producersArray;
            
            $writers = $productionInfo->writers()->get();
            $writersArray = [];
            foreach ($writers as $writer) {
                $writersArray[] = new Resource($writer);
            }
            
            $productionInfo['writers'] = $writersArray;
            
            $cast = $productionInfo->cast()->get();
            $castArray = [];
            foreach ($cast as $castItem) {
                $castArray[] = new Resource($castItem);
            }
            
            $productionInfo['cast'] = $castArray;
            
            $product['production_info'] = new Resource($productionInfo);
        }
        
        if (isset($product['marketing_assets_id'])) {
            $marketingAssets = MarketingAssets::where('id', $product['marketing_assets_id'])->first();
            $marketingAssetsResource = new Resource($marketingAssets);
            
            $productionImages = $marketingAssets->production_images;
            foreach ($productionImages as $productionImage) {
                $marketingAssetsResource['production_images'][$productionImage->id] = new Resource($productionImage);
            }
            
            $marketingAssetsResource['key_artwork'] = new Resource($marketingAssets->key_artwork);
            
            $product['marketing_assets'] = new Resource($marketingAssets);
        }
        
        if (isset($product['movie_id'])) {
            $price = Video::where('id', $product['movie_id'])->first();
            $product['movie'] = new Resource($price);
        }
        
        if (isset($product['screener_id'])) {
            $price = Video::where('id', $product['screener_id'])->first();
            $product['screener'] = new Resource($price);
        }
        
        if (isset($product['trailer_id'])) {
            $price = Video::where('id', $product['trailer_id'])->first();
            $product['trailer'] = new Resource($price);
        }
        
        
        return $product;
    }
}
