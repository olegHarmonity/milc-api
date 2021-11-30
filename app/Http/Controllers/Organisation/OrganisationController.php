<?php
namespace App\Http\Controllers\Organisation;

use App\Helper\FileUploader;
use App\Helper\SearchFormatter;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use App\Http\Controllers\Controller;
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
use App\Util\OrganisationStatuses;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrganisationAcceptedEmail;
use App\Mail\OrganisationDeclinedEmail;

class OrganisationController extends Controller
{

    public function index(Request $request)
    {
        $organisations = SearchFormatter::getSearchQueries($request, Organisation::class);
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
        $data = $request->validated();

        if ($request->file('logo')) {
            $image = FileUploader::uploadFile($request, 'image', 'logo');
            $data['logo_id'] = $image->id;
        }

        $organisation->update($data);

        return (new OrganisationResource($organisation))->response()->setStatusCode(Response::HTTP_OK);
    }

    public function updateStatus(UpdateOrganisationStatusRequest $request, $id)
    {
        $organisation = Organisation::findOrFail($id);
        Gate::authorize('updateStatus', $organisation);

        try {
            $statusRequest = $request->validated();

            $organisation->update($statusRequest);

            if ($statusRequest['status'] === OrganisationStatuses::$ACCEPTED) {
                Mail::to($organisation->email)->send(new OrganisationAcceptedEmail($organisation->organisation_owner->first_name));
            }

            if ($statusRequest['status'] === OrganisationStatuses::$DECLINED) {
                Mail::to($organisation->email)->send(new OrganisationDeclinedEmail($organisation->organisation_owner->first_name));
            }

            return (new OrganisationResource($organisation))->response()->setStatusCode(Response::HTTP_OK);
        } catch (Throwable $e) {
            DB::rollback();
            throw new BadRequestHttpException($e->getMessage());
        }
    }
}
