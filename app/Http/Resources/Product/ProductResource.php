<?php

namespace App\Http\Resources\Product;

use App\Http\Resources\Resource;
use App\Models\MarketingAssets;
use App\Models\MovieGenre;
use App\Models\Product;
use App\Models\ProductionInfo;
use App\Models\Video;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    public function toArray($request)
    {
        $product = parent::toArray($request);

        $productFromDb = Product::findOrFail($product['id']);
        $availableFormats = $productFromDb->available_formats()->get();
        foreach ($availableFormats as $availableFormat){
            $product['available_formats'][] = new Resource($availableFormat);
        }

        $rightsInformation = $productFromDb->rights_information()->get();
        foreach ($rightsInformation as $rightsInformationItem){

            $rightsInformationResource = new Resource($rightsInformationItem);;

            $availableRights = $rightsInformationItem->available_rights()->get();
            $availableRightsArray = [];
            foreach ($availableRights as $availableRight){
                $availableRightsArray[] = new Resource($availableRight);
            }

            $rightsInformationResource['available_rights'] = $availableRightsArray;
            $product['rights_information'][] = $rightsInformationResource;
        }

        if(isset($product['genre_id'])){
            $genre = MovieGenre::where('id',$product['genre_id'])->get();
            $product['genre'] = new Resource($genre);
        }

        if(isset($product['production_info_id'])){
            $productionInfo = ProductionInfo::where('id',$product['production_info_id'])->first();

            $directors = $productionInfo->directors()->get();
            $directorsArray = [];
            foreach ($directors as $director){
                $directorsArray[] = new Resource($director);
            }

            $productionInfo['directors'] = $directorsArray;

            $producers = $productionInfo->producers()->get();
            $producersArray = [];
            foreach ($producers as $producer){
                $producersArray[] = new Resource($producer);
            }

            $productionInfo['producers'] = $producersArray;

            $writers = $productionInfo->writers()->get();
            $writersArray = [];
            foreach ($writers as $writer){
                $writersArray[] = new Resource($writer);
            }

            $productionInfo['writers'] = $writersArray;

            $cast = $productionInfo->cast()->get();
            $castArray = [];
            foreach ($cast as $castItem){
                $castArray[] = new Resource($castItem);
            }

            $productionInfo['cast'] = $castArray;

            $product['production_info'] = new Resource($productionInfo);
        }

        if(isset($product['marketing_assets_id'])){
            $genre = MarketingAssets::where('id',$product['marketing_assets_id'])->get();
            $product['marketing_assets'] = new Resource($genre);
        }

        if(isset($product['movie_id'])){
            $genre = Video::where('id',$product['movie_id'])->get();
            $product['movie'] = new Resource($genre);
        }

        if(isset($product['screener_id'])){
            $genre = Video::where('id',$product['screener_id'])->get();
            $product['screener'] = new Resource($genre);
        }

        if(isset($product['trailer_id'])){
            $genre = Video::where('id',$product['trailer_id'])->get();
            $product['trailer'] = new Resource($genre);
        }

        return $product;
    }
}
