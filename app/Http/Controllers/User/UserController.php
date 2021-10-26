<?php

namespace App\Http\Controllers\User;

use App\Helper\FileUploader;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\RegisterUserRequest;
use App\Http\Resources\User\RegisterResource;
use App\Http\Resources\User\UserResource;
use App\Models\Organisation;
use App\Models\User;
use App\Util\UserRoles;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Throwable;

class UserController extends Controller
{
    public function me()
    {
        return (new RegisterResource(auth()->user()))
            ->response()
            ->setStatusCode(Response::HTTP_OK);
    }

    public function register(RegisterUserRequest $request)
    {
        try {
            DB::beginTransaction();
            $arrayRequest = $request->all();
            $organisationRequest = $arrayRequest['organisation'];
            unset($arrayRequest['organisation']);
            $userRequest = $arrayRequest;

            if ($request->file('organisation.logo')) {
                $image = FileUploader::uploadImage($request);
                $organisationRequest['logo_id'] = $image->id;
            }

            $organisation = Organisation::create($organisationRequest);
            $userRequest['organisation_id'] = $organisation->id;
            $userRequest['role'] = UserRoles::$ROLE_COMPANY_ADMIN;

            $user = User::create($userRequest);
            $organisation->user_id = $user->id;
            $organisation->save();

            DB::commit();

            return (new RegisterResource($user))
                ->response()
                ->setStatusCode(Response::HTTP_CREATED);

        } catch (Throwable $e) {
            DB::rollback();
            throw new BadRequestHttpException($e->getMessage());
        }
    }
}
