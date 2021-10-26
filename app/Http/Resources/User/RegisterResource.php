<?php

namespace App\Http\Resources\User;

use App\Http\Resources\ImageResource;
use App\Http\Resources\Organisation\OrganisationResource;
use App\Models\Image;
use App\Models\Organisation;
use Illuminate\Http\Resources\Json\JsonResource;

class RegisterResource extends JsonResource
{
    public function toArray($request)
    {
        $user = parent::toArray($request);

        if(isset($user['organisation_id'])){
            $organisation = Organisation::where('id',$user['organisation_id'])->get();
            $user['organisation'] = new OrganisationResource($organisation);
            unset($user['organisation_id']);
        }

        return $user;
    }
}
