<?php

namespace App\DataTransformer\Product;

use App\Models\MarketingAssets;
use App\Models\Organisation;
use App\Models\Person;
use App\Models\Product;
use App\Models\ProductionInfo;
use App\Models\RightsInformation;
use Illuminate\Support\Facades\DB;

class ProductStoreDataTransformer
{
    public static function transformData($arrayRequest, Organisation $organisation)
    {
        DB::beginTransaction();

        $availableFormatsRequest = $genresRequest = [];
        if (isset($arrayRequest['available_formats'])) {
            $availableFormatsRequest = $arrayRequest['available_formats'];
            unset($arrayRequest['available_formats']);
        }

        if (isset($arrayRequest['genres'])) {
            $genresRequest = $arrayRequest['genres'];
            unset($arrayRequest['genres']);
        }

        $dubFilesRequest = [];
        if (isset($arrayRequest['dub_files'])) {
            $dubFilesRequest = $arrayRequest['dub_files'];
            unset($arrayRequest['dub_files']);
        }

        $subtitlesRequest = [];
        if (isset($arrayRequest['subtitles'])) {
            $subtitlesRequest = $arrayRequest['subtitles'];
            unset($arrayRequest['subtitles']);
        }

        $promotionalVideosRequest = [];
        if (isset($arrayRequest['promotional_videos'])) {
            $promotionalVideosRequest = $arrayRequest['promotional_videos'];
            unset($arrayRequest['promotional_videos']);
        }

        $productionInfoRequest = $arrayRequest['production_info'];

        if (isset($productionInfoRequest['directors'])) {
            $directorsRequest = $productionInfoRequest['directors'];
            unset($productionInfoRequest['directors']);
        }
        
        if (isset($productionInfoRequest['producers'])) {
            $producersRequest = $productionInfoRequest['producers'];
            unset($productionInfoRequest['producers']);
        }
        
        if (isset($productionInfoRequest['writers'])) {
            $writersRequest = $productionInfoRequest['writers'];
            unset($productionInfoRequest['writers']);
        }
        if (isset($productionInfoRequest['cast'])) {
            $castRequest = $productionInfoRequest['cast'];
            unset($productionInfoRequest['cast']);
        }

        unset($arrayRequest['production_info']);

        $marketingAssetsRequest = $arrayRequest['marketing_assets'];
        unset($arrayRequest['marketing_assets']);

        $productionImagesRequest = [];
        if (isset($marketingAssetsRequest['production_images'])) {
            $productionImagesRequest = $marketingAssetsRequest['production_images'];
            unset($marketingAssetsRequest['production_images']);
        }

        $rightsInformationRequest = $arrayRequest['rights_information'];
        unset($arrayRequest['rights_information']);

        $productRequest = $arrayRequest;

        $productionInfo = ProductionInfo::create($productionInfoRequest);
        $productRequest['production_info_id'] = $productionInfo->id;

        if (isset($directorsRequest)) {
            foreach ($directorsRequest as $directorRequest) {
                $director = Person::create($directorRequest);
                $productionInfo->directors()->attach($director->id);
            }
        }

        if (isset($producersRequest)) {
            foreach ($producersRequest as $producerRequest) {
                $producer = Person::create($producerRequest);
                $productionInfo->producers()->attach($producer->id);
            }
        }

        if (isset($writersRequest)) {
            foreach ($writersRequest as $writerRequest) {
                $writer = Person::create($writerRequest);
                $productionInfo->writers()->attach($writer->id);
            }
        }

        if (isset($castRequest)) {
            foreach ($castRequest as $castRequestItem) {
                $cast = Person::create($castRequestItem);
                $productionInfo->cast()->attach($cast->id);
            }
        }

        $marketingAssets = MarketingAssets::create($marketingAssetsRequest);

        foreach ($productionImagesRequest as $productionImageId) {
            $marketingAssets->production_images()->attach($productionImageId);
        }

        $productRequest['marketing_assets_id'] = $marketingAssets->id;

        $rightsInformationArray = [];
        foreach ($rightsInformationRequest as $rightsInformationRequestItem) {

            if (isset($rightsInformationRequestItem['available_rights'])) {
                $availableRightsRequest = $rightsInformationRequestItem['available_rights'];
                unset($rightsInformationRequestItem['available_rights']);
            }

            $rightsInformation = RightsInformation::create($rightsInformationRequestItem);

            if (isset($availableRightsRequest)) {
                foreach ($availableRightsRequest as $availableRightId) {
                    $rightsInformation->available_rights()->attach($availableRightId);
                }
            }

            $rightsInformationArray[] = $rightsInformation;
        }

        $productRequest['organisation_id'] = $organisation->id;

        $product = Product::create($productRequest);

        foreach ($availableFormatsRequest as $availableFormatId) {
            $product->available_formats()->attach($availableFormatId);
        }

        foreach ($genresRequest as $genreId) {
            $product->genres()->attach($genreId);
        }

        foreach ($dubFilesRequest as $dubFileId) {
            $product->dub_files()->attach($dubFileId);
        }

        foreach ($subtitlesRequest as $subtitlesId) {
            $product->subtitles()->attach($subtitlesId);
        }

        foreach ($promotionalVideosRequest as $promotionalVideosId) {
            $product->promotional_videos()->attach($promotionalVideosId);
        }

        foreach ($rightsInformationArray as $rightsInformation) {
            $product->rights_information()->attach($rightsInformation->id);
            $rightsInformation->product_id = $product->id;
            $rightsInformation->save();
        }

        $productionInfo->product_id = $product->id;
        $productionInfo->save();

        $marketingAssets->product_id = $product->id;
        $marketingAssets->save();

        DB::commit();

        return $product;
    }
}
