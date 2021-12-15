<?php
namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Models\RightsInformation;
use App\Http\Resources\Resource;

class RightsInfoController extends Controller
{
    public function show($id)
    {
        $rightsInfo = RightsInformation::findOrFail($id);
    
        $rightsInfoResource = new Resource($rightsInfo);
        
        $availableRights = $rightsInfo->available_rights()->get();
        
        $availableRightsArray = [];
        foreach ($availableRights as $availableRight) {
            $availableRightsArray[] = new Resource($availableRight);
        }
        
        $rightsInfoResource['available_rights'] = $availableRightsArray;
        
        return $rightsInfoResource;
    }
    
}

