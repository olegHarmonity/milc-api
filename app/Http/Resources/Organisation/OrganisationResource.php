<?php

namespace App\Http\Resources\Organisation;

use App\Http\Resources\ImageResource;
use App\Models\Image;
use App\Models\Organisation;
use App\Models\OrganisationType;
use Illuminate\Http\Resources\Json\JsonResource;

class OrganisationResource extends JsonResource
{
    public function toArray($request)
    {
        $this->makeVisible(['status']);

        $organisation = parent::toArray($request);
        if (isset($organisation[0])) {
            $organisation = $organisation[0];
        }

        if (isset($organisation['logo_id'])) {
            $image = Image::where('id', $organisation['logo_id'])->get();
            $organisation['logo'] = new ImageResource($image);
            unset($organisation['logo_id']);
        }

        if (isset($organisation['organisation_type_id'])) {
            $orgType = OrganisationType::where('id', $organisation['organisation_type_id'])->get();
            $organisation['organisation_type'] = new OrganisationTypeResource($orgType);
            unset($organisation['organisation_type_id']);
        }

        return $organisation;
    }
}
