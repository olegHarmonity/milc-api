<?php
namespace App\Http\Resources\Product;

use App\Models\Image;
use App\Http\Resources\ImageResource;
use Illuminate\Http\Resources\Json\JsonResource;

class PersonResource extends JsonResource
{
    public function toArray($request)
    {
        $person = parent::toArray($request);
        if (isset($person[0])) {
            $person = $person[0];
        }
        
        if (isset($person['image_id'])) {
            $image = Image::where('id', $person['image_id'])->get();
            $person['image'] = new ImageResource($image);
        }
        
        return $person;
    }
}

