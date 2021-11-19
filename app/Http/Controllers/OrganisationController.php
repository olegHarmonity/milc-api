<?php

namespace App\Http\Controllers;

use App\Helper\SearchFormatter;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use App\Http\Requests\Organisation\UpdateOrganisationRequest;
use App\Http\Requests\Organisation\UpdateOrganisationStatusRequest;
use App\Http\Resources\Organisation\OrganisationCollectionResource;
use App\Http\Resources\Organisation\OrganisationResource;
use App\Models\Organisation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

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
        $organisation->update($request->validated());
      

        return (new OrganisationResource($organisation))
            ->response()
            ->setStatusCode(Response::HTTP_OK);
    }
    
    
    public function updateStatus(UpdateOrganisationStatusRequest $request, $id)
    {
        $organisation = Organisation::findOrFail($id);
        Gate::authorize('updateStatus', $organisation);
        
        try {
            $organisation->update($request->validated());
   
            return (new OrganisationResource($organisation))
            ->response()
            ->setStatusCode(Response::HTTP_OK);
        } catch (Throwable $e) {
            DB::rollback();
            throw new BadRequestHttpException($e->getMessage());
        }
    }
}
