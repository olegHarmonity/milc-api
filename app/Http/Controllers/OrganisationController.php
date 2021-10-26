<?php

namespace App\Http\Controllers;

use App\Http\Resources\ImageResource;
use App\Http\Resources\OrganisationResource;
use App\Models\Image;
use App\Models\Organisation;
use Illuminate\Http\Request;

class OrganisationController extends Controller
{
    public function index()
    {
        return new  OrganisationResource(Organisation::all());
    }

    public function show(int $id)
    {
        return new OrganisationResource(Organisation::find($id));
    }
}
