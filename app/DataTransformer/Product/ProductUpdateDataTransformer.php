<?php
namespace App\DataTransformer\Product;

use App\Models\Person;
use App\Models\Product;
use App\Models\RightsInformation;
use Illuminate\Support\Facades\DB;
use App\Models\RightsBundle;
use App\Models\Money;

class ProductUpdateDataTransformer
{

    public static function transformData($arrayRequest, Product $product)
    {
        DB::beginTransaction();

        if (isset($arrayRequest['available_formats'])) {
            $availableFormatsRequest = $arrayRequest['available_formats'];
            unset($arrayRequest['available_formats']);
        }

        if (isset($arrayRequest['genres'])) {
            $genresRequest = $arrayRequest['genres'];
            unset($arrayRequest['genres']);
        }

        if (isset($arrayRequest['dub_files'])) {
            $dubFilesRequest = $arrayRequest['dub_files'];
            unset($arrayRequest['dub_files']);
        }

        if (isset($arrayRequest['subtitles'])) {
            $subtitlesRequest = $arrayRequest['subtitles'];
            unset($arrayRequest['subtitles']);
        }

        if (isset($arrayRequest['promotional_videos'])) {
            $promotionalVideosRequest = $arrayRequest['promotional_videos'];
            unset($arrayRequest['promotional_videos']);
        }

        if (isset($arrayRequest['bundle_rights'])) {
            $rightsBundlesRequest = $arrayRequest['bundle_rights'];
            unset($arrayRequest['bundle_rights']);
        }

        if (isset($arrayRequest['production_info'])) {
            $productionInfoRequest = $arrayRequest['production_info'];
        }

        if (isset($productionInfoRequest)) {
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
        }

        unset($arrayRequest['production_info']);

        if (isset($arrayRequest['marketing_assets'])) {
            $marketingAssetsRequest = $arrayRequest['marketing_assets'];
            unset($arrayRequest['marketing_assets']);
        }

        if (isset($marketingAssetsRequest) && isset($marketingAssetsRequest['production_images'])) {
            $productionImagesRequest = $marketingAssetsRequest['production_images'];
            unset($marketingAssetsRequest['production_images']);
        }

        if (isset($arrayRequest['rights_information'])) {
            $rightsInformationRequest = $arrayRequest['rights_information'];
            unset($arrayRequest['rights_information']);
        }

        $productRequest = $arrayRequest;

        $productionInfo = $product->production_info()->first();

        if (isset($productionInfoRequest)) {
            $productionInfo->update($productionInfoRequest);
        }

        $productRequest['production_info_id'] = $productionInfo->id;

        if (isset($rightsBundlesRequest)) {
            $product->rights_bundles()->detach();
            foreach ($rightsBundlesRequest as $bundleRightRequest) {

                if (isset($bundleRightRequest['rights_information'])) {
                    $rightsBundlesRightsInfoRequest = $bundleRightRequest['rights_information'];
                    unset($bundleRightRequest['rights_information']);
                }

                $priceRequest = [];
                if (isset($bundleRightRequest['price'])) {
                    $priceRequest = $bundleRightRequest['price'];
                    unset($bundleRightRequest['price']);
                }

                if (isset($priceRequest['id'])) {
                    $price = Money::findOrFail($priceRequest['id']);
                    $price->update($priceRequest);
                } else {
                    $price = Money::create($priceRequest);
                }

                $price->save();

                $bundleRightRequest['price_id'] = $price->id;
                $bundleRightRequest['product_id'] = $product->id;

                if (isset($bundleRightRequest['id'])) {
                    $bundleRight = RightsBundle::findOrFail($bundleRightRequest['id']);
                    $bundleRight->update($bundleRightRequest);
                } else {
                    $bundleRight = RightsBundle::create($bundleRightRequest);
                }

                $bundleRight->save();

                if (isset($rightsBundlesRightsInfoRequest)) {
                    $bundleRight->bundle_rights_information()->detach();

                    foreach ($rightsBundlesRightsInfoRequest as $rightsBundlesRightInfoRequest) {
                        $bundleRight->bundle_rights_information()->attach($rightsBundlesRightInfoRequest);
                    }
                }

                $bundleRight->save();

                $product->rights_bundles()->attach($bundleRight->id);
            }
        }

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

        $marketingAssets = $product->marketing_assets;

        if (isset($productionImagesRequest)) {
            $marketingAssets->production_images()->detach();

            foreach ($productionImagesRequest as $productionImageId) {
                $marketingAssets->production_images()->attach($productionImageId);
            }
        }

        if (isset($marketingAssetsRequest)) {
            $marketingAssets->update($marketingAssetsRequest);
        }

        $productRequest['marketing_assets_id'] = $marketingAssets->id;

        if (isset($rightsInformationRequest)) {
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
                
                $rightsInformation->product_id = $product->id;

                if (isset($availableRightsRequest) && count($availableRightsRequest) > 0) {
                    $rightsInformation->available_rights()->detach();
                    foreach ($availableRightsRequest as $availableRightId) {
                        $rightsInformation->available_rights()->attach($availableRightId);
                    }
                }

                $rightsInformationArray[] = $rightsInformation;
            }
        }
        
        $product->update($productRequest);

        if (isset($availableFormatsRequest)) {
            $product->available_formats()->detach();

            foreach ($availableFormatsRequest as $availableFormatId) {
                $product->available_formats()->attach($availableFormatId);
            }
        }

        if (isset($genresRequest)) {
            $product->genres()->detach();

            foreach ($genresRequest as $genreId) {
                $product->genres()->attach($genreId);
            }
        }

        if (isset($dubFilesRequest)) {
            $product->dub_files()->detach();

            foreach ($dubFilesRequest as $dubFileId) {
                $product->dub_files()->attach($dubFileId);
            }
        }

        if (isset($subtitlesRequest)) {
            $product->subtitles()->detach();

            foreach ($subtitlesRequest as $subtitlesId) {
                $product->subtitles()->attach($subtitlesId);
            }
        }

        if (isset($promotionalVideosRequest)) {
            $product->promotional_videos()->detach();

            foreach ($promotionalVideosRequest as $promotionalVideosId) {
                $product->promotional_videos()->attach($promotionalVideosId);
            }
        }

        if (isset($rightsInformationArray)) {
            $product->rights_information()->detach();

            foreach ($rightsInformationArray as $rightsInformationEntity) {
                $product->rights_information()->attach($rightsInformationEntity->id);
                $rightsInformationEntity->product_id = $product->id;
                $rightsInformationEntity->save();
            }
        }

        $productionInfo->product_id = $product->id;
        $productionInfo->save();

        $marketingAssets->product_id = $product->id;
        $marketingAssets->save();

        DB::commit();

        return $product;
    }
}
