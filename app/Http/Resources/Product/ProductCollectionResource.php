<?php

namespace App\Http\Resources\Product;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductCollectionResource  extends JsonResource
{
    public function toArray($request)
    {
        return parent::toArray($request);
    }
}
