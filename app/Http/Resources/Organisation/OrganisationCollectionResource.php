<?php

namespace App\Http\Resources\Organisation;

use Illuminate\Http\Resources\Json\JsonResource;

class OrganisationCollectionResource extends JsonResource
{
    public function toArray($request)
    {
        return parent::toArray($request);
    }
}
