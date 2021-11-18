<?php

namespace App\Http\Controllers;

use App\Helper\SearchFormatter;
use App\Http\Requests\Organisation\UpdateOrganisationRequest;
use App\Http\Resources\Organisation\OrganisationCollectionResource;
use App\Http\Resources\Organisation\OrganisationResource;
use App\Models\Organisation;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class OrganisationController extends Controller
{
    public function index(Request $request)
    {
        $organisations = SearchFormatter::getSearchQuery($request, Organisation::class);
        $organisations = $organisations->with('organisation_type:id,name');
        $organisations = $organisations->paginate($request->input('per_page'));

        return new OrganisationCollectionResource($organisations);
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
