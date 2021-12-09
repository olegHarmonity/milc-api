<?php
namespace App\Http\Resources\Organisation;

use App\Http\Resources\Resource;
use App\Http\Resources\ImageResource;
use App\Models\Image;
use App\Models\Organisation;
use App\Models\OrganisationType;
use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\User\UserResource;
use App\Models\Percentage;

class OrganisationResource extends JsonResource
{

    public function toArray($request)
    {
        $this->makeVisible([
            'status'
        ]);

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
        }

        if (isset($organisation['organisation_owner_id'])) {
            $owner = User::where('id', $organisation['organisation_owner_id'])->get();
            $organisation['organisation_owner'] = new UserResource($owner);
        }

        $organisationFromDb = Organisation::findOrFail($organisation['id']);

        $vatRules = $organisationFromDb->vat_rules()->get();
        foreach ($vatRules as $vatRules) {
            $vatRulesResponse = new Resource($vatRules);

            if (isset($vatRulesResponse['vat_id'])) {
                $vat = Percentage::where('id', $vatRulesResponse['vat_id'])->first();
                $vatRulesResponse['vat'] = new Resource($vat);
            }

            $organisation['vat_rules'][] = $vatRulesResponse;
        }

        return $organisation;
    }
}
