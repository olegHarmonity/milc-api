<?php

namespace App\Http\Controllers\User;

use App\Helper\FileUploader;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\EmailExistsRequest;
use App\Http\Requests\User\RegisterUserRequest;
use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Http\Resources\CollectionResource;
use App\Http\Resources\User\EmailExistsResource;
use App\Http\Resources\User\RegisterResource;
use App\Http\Resources\User\UserResource;
use App\Models\Organisation;
use App\Models\User;
use App\Util\UserRoles;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Throwable;

class UserController extends Controller
{
    public function me()
    {
        Gate::authorize('me', auth()->user());

        return (new RegisterResource(auth()->user()))
            ->response()
            ->setStatusCode(Response::HTTP_OK);
    }

    public function emailExists(EmailExistsRequest $request)
    {
        $response = [];
        $email = $request->get('email');
        $response['email_exists'] = false;

        if (!$email) {
            return (new EmailExistsResource($response))
                ->response()
                ->setStatusCode(Response::HTTP_OK);
        }

        $user = User::firstWhere('email', '=', $email);

        if ($user instanceof User) {
            $response['email_exists'] = true;
        }

        return (new EmailExistsResource($response))
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
                $image = FileUploader::uploadFile($request, 'image', 'organisation.logo');
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


    public function update(UpdateUserRequest $request, User $user)
    {
        Gate::authorize('update', $user);

        $user->update($request->validated());

        return response()->json([
            'data' => UserResource::make($user),
            'message' => 'User updated!'
        ]);
    }

    public function change_password(Request $request)
    {
        Gate::authorize('update', auth()->user());

        $status = 200;
        $input = $request->all();
        $userid = auth()->user()->id;
        $rules = array(
            'old_password' => 'required',
            'new_password' => 'required|min:6',
            'password_confirmation' => 'required|same:new_password',
        );
        $validator = Validator::make($input, $rules);
        if ($validator->fails()) {
            $status = 400;
            $arr = array("status" => $status, "message" => $validator->errors()->first(), "data" => array());
        } else {
            try {
                if ((Hash::check(request('old_password'), Auth::user()->password)) == false) {
                    $status = 400;
                    $arr = array("status" => $status, "message" => "Check your old password.", "data" => array());
                } else if ((Hash::check(request('new_password'), Auth::user()->password)) == true) {
                    $status = 400;
                    $arr = array("status" => $status, "message" => "Please enter a password which is not similar then current password.", "data" => array());
                } else {
                    User::where('id', $userid)->update(['password' => Hash::make($input['new_password'])]);
                    $arr = array("status" => 200, "message" => "Password updated successfully.", "data" => array());
                }
            } catch (\Exception $ex) {
                if (isset($ex->errorInfo[2])) {
                    $msg = $ex->errorInfo[2];
                } else {
                    $msg = $ex->getMessage();
                }
                $status = 400;
                $arr = array("status" => $status, "message" => $msg, "data" => array());
            }
        }
        return response()->json($arr, $status);
    }

    public function index(Request $request)
    {
        $users = User::query();

        if (!$this->user()->isAdmin()) {
            $users->where('organisation_id', $this->user()->organisation_id);
            $users->select(['id', 'first_name', 'last_name', 'email', 'status']);
        }

        $users = $users->paginate($request->input('per_page'));

        return $users;
    }

    public function store(StoreUserRequest $request)
    {
        $data = $request->validated();

        if ($this->user()->isAdmin()) {
            $data['organisation_id'] = $request->input('organisation_id');
        } else {
            $data['organisation_id'] = $this->user()->organisation_id;
        }

        /** @var \App\Models\User */
        $user = User::create($data);
        $user->refresh();

        return UserResource::make($user);
    }

    public function destroy(User $user)
    {
        Gate::authorize('delete', $user);

        $user->delete();

        return response()->json([
            'message' => 'User deleted!'
        ]);
    }
}
