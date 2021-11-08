<?php

namespace App\Http\Controllers;

use App\Http\Resources\CollectionResource;
use App\Http\Resources\Resource;
use App\Models\Video;
use Illuminate\Http\Request;

class VideoController extends Controller
{
    public function index()
    {
        return new  CollectionResource(Video::all());
    }

    public function show(int $id)
    {
        return new Resource(Video::find($id));
    }
}
