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
        }
        
        if (isset($user['image_id'])) {
            $image = Image::where('id', $user['image_id'])->get();
            $user['image'] = new ImageResource($image);
        }

        return $user;
    }
}
