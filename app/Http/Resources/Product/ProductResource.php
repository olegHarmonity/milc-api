<?php

namespace App\Http\Resources\Product;

use App\Http\Resources\Resource;
use App\Models\MarketingAssets;
use App\Models\MovieContentType;
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
        foreach ($availableFormats as $availableFormat) {
            $product['available_formats'][] = new Resource($availableFormat);;
        }

        $genres = $productFromDb->genres()->get();
        foreach ($genres as $genre) {
            $product['genres'][] = new Resource($genre);
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

            $productionImages = $marketingAssets->production_images()->get();
            foreach ($productionImages as $productionImage) {
                $marketingAssetsResource['production_images'][$productionImage->id] = new Resource($productionImage);
            }

            $marketingAssetsResource['key_artwork'] = new Resource($marketingAssets->key_artwork);

            $product['marketing_assets'] = new Resource($marketingAssets);
        }

        if (isset($product['movie_id'])) {
            $genre = Video::where('id', $product['movie_id'])->first();
            $product['movie'] = new Resource($genre);
        }

        if (isset($product['screener_id'])) {
            $genre = Video::where('id', $product['screener_id'])->first();
            $product['screener'] = new Resource($genre);
        }

        if (isset($product['trailer_id'])) {
            $genre = Video::where('id', $product['trailer_id'])->first();
            $product['trailer'] = new Resource($genre);
        }

        return $product;
    }
}
