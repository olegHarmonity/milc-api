<?php

namespace App\Http\Resources\Organisation;

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
