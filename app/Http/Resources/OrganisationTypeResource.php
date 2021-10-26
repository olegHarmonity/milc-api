<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrganisationTypeResource extends JsonResource
{
    public function toArray($request)
    {
        $this->makeVisible(['slug']);

        $organisationType = parent::toArray($request);
        return $organisationType[0];
    }
}
