<?php

namespace App\Http\Resources\User;

use App\Models\Image;
use App\Http\Resources\ImageResource;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public function toArray($request)
    {
        $user = parent::toArray($request);
        
        if (isset($user[0])) {
            $user = $user[0];
        }
        
        if (isset($user['image_id'])) {
            $image = Image::where('id', $user['image_id'])->get();
            $user['image'] = new ImageResource($image);
        }
        
        return $user;
    }
}
