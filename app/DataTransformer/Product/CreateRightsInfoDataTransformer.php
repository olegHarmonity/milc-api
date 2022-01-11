<?php
namespace App\DataTransformer\Product;

use App\Models\Product;
use App\Models\RightsInformation;
use Illuminate\Support\Facades\DB;

class CreateRightsInfoDataTransformer
{

    public static function transformData($arrayRequest, Product $product)
    {
        DB::beginTransaction();

        if (isset($arrayRequest['available_rights'])) {
            $availableRightsRequest = $arrayRequest['available_rights'];
            unset($arrayRequest['available_rights']);
        }

        $rightsInformation = RightsInformation::create($arrayRequest);
        $rightsInformation->save();

        $rightsInformation->available_rights()->detach();
        if (isset($availableRightsRequest)) {
            foreach ($availableRightsRequest as $availableRightId) {
                $rightsInformation->available_rights()->attach($availableRightId);
            }
        }

        $rightsInformation->save();

        $product->rights_information()->attach($rightsInformation->id);
        $product->save();

        DB::commit();

        return $product;
    }
}

