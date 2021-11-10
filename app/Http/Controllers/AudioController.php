<?php

namespace App\Http\Controllers;

use App\Http\Resources\CollectionResource;
use App\Http\Resources\Resource;
use App\Models\Audio;

class AudioController extends Controller
{
    public function index()
    {
        return new  CollectionResource(Audio::all());
    }

    public function show(int $id)
    {
        return new Resource(Audio::findOrFail($id));
    }
}
