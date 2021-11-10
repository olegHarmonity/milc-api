<?php

namespace App\Http\Controllers;

use App\Http\Resources\ImageResource;
use App\Models\Image;

class ImageController extends Controller
{
    public function index()
    {
        return new  ImageResource(Image::all());
    }

    public function show(int $id)
    {
        return new ImageResource(Image::findOrFail($id));
    }
}
