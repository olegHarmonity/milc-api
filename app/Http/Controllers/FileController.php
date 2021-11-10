<?php

namespace App\Http\Controllers;

use App\Http\Resources\CollectionResource;
use App\Http\Resources\Resource;
use App\Models\File;
use Illuminate\Http\Request;

class FileController extends Controller
{
    public function index()
    {
        return new  CollectionResource(File::all());
    }

    public function show(int $id)
    {
        return new Resource(File::findOrFail($id));
    }
}
