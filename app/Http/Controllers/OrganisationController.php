<?php

namespace App\Http\Controllers;

use App\Http\Requests\Organisation\UpdateOrganisationRequest;
use App\Http\Resources\Organisation\OrganisationCollectionResource;
use App\Http\Resources\Organisation\OrganisationResource;
use App\Models\Organisation;
use Symfony\Component\HttpFoundation\Response;

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



    public function update(UpdateOrganisationRequest $request, int $id)
    {
        $organisation = Organisation::find($id);

        $organisation->update($request->all());

        return (new OrganisationResource($organisation))
            ->response()
            ->setStatusCode(Response::HTTP_OK);
    }
}
