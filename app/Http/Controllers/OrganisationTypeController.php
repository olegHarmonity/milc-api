<?php

namespace App\Http\Controllers;

use App\Http\Resources\OrganisationResource;
use App\Http\Resources\OrganisationTypeResource;
use App\Models\Image;
use App\Models\OrganisationType;
use Illuminate\Http\Request;

class OrganisationTypeController extends Controller
{
    public function index()
    {
        return new  OrganisationTypeResource(OrganisationType::all());
    }

    public function show(int $id)
    {
        return new OrganisationTypeResource(OrganisationType::find($id));
    }
}
