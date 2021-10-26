<?php

namespace App\Http\Controllers;

use App\Http\Resources\Organisation\OrganisationCollectionResource;
use App\Http\Resources\Organisation\OrganisationResource;
use App\Models\Organisation;

class OrganisationController extends Controller
{
    public function index()
    {
        return new OrganisationCollectionResource(Organisation::all());
    }

    public function show(int $id)
    {
        return new OrganisationResource(Organisation::find($id));
    }
}
