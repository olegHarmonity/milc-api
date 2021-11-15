<?php

namespace App\Http\Controllers;

use App\Helper\SearchFormatter;
use App\Http\Resources\Organisation\OrganisationTypeCollectionResource;
use App\Http\Resources\Organisation\OrganisationTypeResource;
use App\Models\Image;
use App\Models\OrganisationType;
use Illuminate\Http\Request;

class OrganisationTypeController extends Controller
{
    public function index(Request $request)
    {
        return new OrganisationTypeCollectionResource(SearchFormatter::getSearchResults($request, OrganisationType::class));
    }

    public function show(int $id)
    {
        return new OrganisationTypeResource(OrganisationType::findOrFail($id));
    }
}
