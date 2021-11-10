<?php

namespace App\DataTransformer\Product;

use App\Models\Person;
use App\Models\Product;
use App\Models\RightsInformation;
use Illuminate\Support\Facades\DB;

class ProductUpdateDataTransformer
{

    public static function transformData($arrayRequest, Product $product)
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

        $rightsInformationRequest = $arrayRequest['rights_information'];
        unset($arrayRequest['rights_information']);

        $productRequest = $arrayRequest;

        $productionInfo = $product->production_info()->first();
        $productionInfo->update($productionInfoRequest);

        $productRequest['production_info_id'] = $productionInfo->id;

        if (isset($directorsRequest)) {
            $productionInfo->directors()->detach();
            foreach ($directorsRequest as $directorRequest) {
                if (isset($directorRequest['id'])) {
                    $director = Person::findOrFail($directorRequest['id']);
                    $director->update($directorRequest);
                } else {
                    $director = Person::create($directorRequest);
                }
                $productionInfo->directors()->attach($director->id);
            }
        }

        if (isset($producersRequest)) {
            $productionInfo->producers()->detach();
            foreach ($producersRequest as $producerRequest) {
                if (isset($producerRequest['id'])) {
                    $producer = Person::findOrFail($producerRequest['id']);
                    $producer->update($producerRequest);
                } else {
                    $producer = Person::create($producerRequest);
                }
                $productionInfo->producers()->attach($producer->id);
            }
        }

        if (isset($writersRequest)) {
            $productionInfo->writers()->detach();
            foreach ($writersRequest as $writerRequest) {
                if (isset($writerRequest['id'])) {
                    $writer = Person::findOrFail($writerRequest['id']);
                    $writer->update($writerRequest);
                } else {
                    $writer = Person::create($writerRequest);
                }
                $productionInfo->writers()->attach($writer->id);
            }
        }

        if (isset($castRequest)) {
            $productionInfo->cast()->detach();
            foreach ($castRequest as $castRequestItem) {
                if (isset($castRequestItem['id'])) {
                    $cast = Person::findOrFail($castRequestItem['id']);
                    $cast->update($castRequestItem);
                } else {
                    $cast = Person::create($castRequestItem);
                }
                $productionInfo->cast()->attach($cast->id);
            }
        }

        $marketingAssets = $product->marketing_assets()->first();
        $marketingAssets->update($marketingAssetsRequest);

        $productRequest['marketing_assets_id'] = $marketingAssets->id;

        $rightsInformationArray = [];
        foreach ($rightsInformationRequest as $rightsInformationRequestItem) {

            if (isset($rightsInformationRequestItem['available_rights'])) {
                $availableRightsRequest = $rightsInformationRequestItem['available_rights'];
                unset($rightsInformationRequestItem['available_rights']);
            }

            $rightsInformation = null;
            if (isset($rightsInformationRequestItem['id'])) {
                $productRightsInformations = $product->rights_information()->get();
                foreach ($productRightsInformations as $productRightsInformation) {
                    if ($productRightsInformation->id === $rightsInformationRequestItem['id']) {
                        $rightsInformation = $productRightsInformation;
                    }
                }
            }

            if (isset($rightsInformation) and $rightsInformation !== null) {
                $rightsInformation->update($rightsInformationRequestItem);
            } else {
                $rightsInformation = RightsInformation::create($rightsInformationRequestItem);
            }

            if (isset($availableRightsRequest)) {
                $rightsInformation->available_rights()->detach();
                foreach ($availableRightsRequest as $availableRightId) {
                    $rightsInformation->available_rights()->attach($availableRightId);
                }
            }

            $rightsInformationArray[] = $rightsInformation;
        }

        $product->update($productRequest);

        $product->available_formats()->detach();
        foreach ($availableFormatsRequest as $availableFormatId) {
            $product->available_formats()->attach($availableFormatId);
        }

        $product->genres()->detach();
        foreach ($genresRequest as $genreId) {
            $product->genres()->attach($genreId);
        }

        $product->rights_information()->detach();
        foreach ($rightsInformationArray as $rightsInformationEntity) {
            $product->rights_information()->attach($rightsInformationEntity->id);
            $rightsInformationEntity->product_id = $product->id;
            $rightsInformationEntity->save();
        }

        $productionInfo->product_id = $product->id;
        $productionInfo->save();

        $marketingAssets->product_id = $product->id;
        $marketingAssets->save();

        DB::commit();

        return $product;
    }
}
