<?php

namespace App\Http\Controllers;

use App\Helper\SearchFormatter;
use App\Http\Requests\Organisation\UpdateOrganisationRequest;
use App\Http\Resources\Organisation\OrganisationCollectionResource;
use App\Http\Resources\Organisation\OrganisationResource;
use App\Models\Organisation;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class OrganisationController extends Controller
{
    public function index(Request $request)
    {
        return new OrganisationCollectionResource(SearchFormatter::getPaginatedSearchResults($request, Organisation::class));
    }

    public function show(int $id)
    {
        return new OrganisationResource(Organisation::findOrFail($id));
    }

    public function update(UpdateOrganisationRequest $request, Organisation $organisation)
    {
        $organisation->update($request->all());

        return (new OrganisationResource($organisation))
            ->response()
            ->setStatusCode(Response::HTTP_OK);
    }
}
