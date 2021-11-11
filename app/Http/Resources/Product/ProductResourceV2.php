<?php

namespace App\Http\Resources\Product;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResourceV2 extends JsonResource
{
    public function toArray($request)
    {
        $resource = parent::toArray($request);

        return $resource;
    }
}
