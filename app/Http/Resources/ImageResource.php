<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ImageResource extends JsonResource
{
    public function toArray($request)
    {
        $image = parent::toArray($request);
        if (isset($image[0])) {
            return $image[0];
        }

        return  $image;
    }
}
