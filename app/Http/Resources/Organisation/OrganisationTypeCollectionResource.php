<?php

namespace App\Http\Resources\Organisation;

use Illuminate\Http\Resources\Json\JsonResource;

class OrganisationTypeCollectionResource extends JsonResource
{
    public function toArray($request)
    {
        $this->makeVisible(['slug']);

        return parent::toArray($request);
    }
}
