<?php
namespace App\Http\Resources\Product;

use App\Models\Image;
use App\Http\Resources\ImageResource;
use Illuminate\Http\Resources\Json\JsonResource;

class MovieGenreResource extends JsonResource
{
    public function toArray($request)
    {
        $movieGenre = parent::toArray($request);
        if (isset($movieGenre[0])) {
            $movieGenre = $movieGenre[0];
        }
        
        if (isset($movieGenre['image_id'])) {
            $image = Image::where('id', $movieGenre['image_id'])->get();
            $movieGenre['image'] = new ImageResource($image);
        }
        
        return $movieGenre;
    }
}

