<?php
namespace App\DataTransformer\Product;

use App\Models\Product;
use App\Models\RightsInformation;
use Illuminate\Support\Facades\DB;
use App\Util\NotificationCategories;
use Database\Factories\NotificationFactory;

class UpdateRightsInfoDataTransformer
{

    public static function transformData($arrayRequest, RightsInformation $rightsInfo)
    {
        DB::beginTransaction();

        if (isset($arrayRequest['available_rights'])) {
            $availableRightsRequest = $arrayRequest['available_rights'];
            unset($arrayRequest['available_rights']);
        }

        $rightsInfo->update($arrayRequest);

        if (isset($availableRightsRequest)) {
            $rightsInfo->available_rights()->detach();
            foreach ($availableRightsRequest as $availableRightId) {
                $rightsInfo->available_rights()->attach($availableRightId);
            }
        }

        $rightsInfo->save();

        $product = $rightsInfo->product;
        $product->rights_information()->attach($rightsInfo->id);
        $product->save();

        DB::commit();

        return $product;
    }
}

