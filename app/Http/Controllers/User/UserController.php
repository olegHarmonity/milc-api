<?php

namespace App\Http\Controllers\User;

use App\Helper\FileUploader;
use App\Helper\SearchFormatter;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\EmailExistsRequest;
use App\Http\Requests\User\RegisterUserRequest;
use App\Http\Requests\User\SaveProductRequest;
use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Http\Resources\CollectionResource;
use App\Http\Resources\User\EmailExistsResource;
use App\Http\Resources\User\RegisterResource;
use App\Http\Resources\User\UserResource;
use App\Models\Organisation;
use App\Models\Product;
use App\Models\User;
use App\Util\UserRoles;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Throwable;
use App\Mail\VerifyAccountEmail;

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
            $arrayRequest = $request->validated();
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

            $organisation->organisation_owner_id = $user->id;
            $organisation->save();

            $verificationCode = str_random(30);
            DB::table('user_verifications')->insert(['user_id' => $user->id, 'token' => $verificationCode]);

            Mail::to($user->email)->send(new VerifyAccountEmail($verificationCode, $user->first_name));

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

        $data = $request->validated();

        if ($request->file('image')) {
            $image = FileUploader::uploadFile($request, 'image', 'image');
            $data['image_id'] = $image->id;
        }

        $user->update($data);
        $user->load('organisation:id,organisation_name');

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
        $users = SearchFormatter::getSearchQueries($request, User::class);

        $users = $users->with('image:id,image_name,image_url,mime,created_at,updated_at');


        if (!$this->user()->isAdmin()) {
            $users->where('organisation_id', $this->user()->organisation_id);
            $users->select(['id', 'first_name', 'last_name', 'email', 'phone_number', 'status', 'image_id', 'created_at']);
        } else {
            $users = $users->with('organisation:id,organisation_name');
            $users->select(['id', 'first_name', 'last_name', 'email', 'status', 'image_id', 'organisation_id']);
        }

        $users = $users->paginate($request->input('per_page'));

        return new CollectionResource($users);
    }

    public function show(User $user)
    {
        Gate::authorize('view', $user);

        $user->load(
            'organisation',
            'organisation.logo:id,image_url',
            'organisation.organisation_type:id,name'
        );
        return UserResource::make($user);
    }

    public function store(StoreUserRequest $request)
    {
        Gate::authorize('create', User::class);

        $data = $request->validated();

        if ($this->user()->isAdmin()) {
            $data['organisation_id'] = $request->input('organisation_id');
        } else {
            $data['organisation_id'] = $this->user()->organisation_id;
        }

        if ($request->file('image')) {
            $image = FileUploader::uploadFile($request, 'image', 'image');
            $data['image_id'] = $image->id;
        }

        /** @var \App\Models\User */
        $user = User::create($data);
        $user->refresh();

        return response()->json([
            'data' => UserResource::make($user),
            'message' => 'User created!'
        ]);
    }

    public function destroy(User $user)
    {
        Gate::authorize('delete', $user);

        $user->delete();

        return response()->json([
            'message' => 'User deleted!'
        ]);
    }

    public function getSavedProducts(Request $request)
    {
        $products = SearchFormatter::getSearchQueries($request, Product::class, $this->user()->saved_products()->getQuery());


        $products = $products->with(
            'content_type:id,name',
            'genres:id,name',
            'available_formats:id,name',
            'marketing_assets:id,key_artwork_id',
            'marketing_assets.key_artwork:id,image_name,image_url',
            'organisation:id,organisation_name',
            'production_info:id,production_year,release_year',
        );

        $products = $products->select([
            'products.id',
            'title',
            'synopsis',
            'runtime',
            'original_language',
            'content_type_id',
            'marketing_assets_id',
            'production_info_id',
            'products.created_at',
            'organisation_id',
            'status',
            'keywords',
            'is_saved'
        ]);

        return CollectionResource::make($products->get());
    }

    public function saveProduct(SaveProductRequest $request)
    {
        $data = $request->validated();

        $product = Product::findOrFail($data['product_id']);
        $user = $this->user();

        $user->saved_products()->attach($product->id);
        $user->save();

        return response()->json([
            'message' => 'Product succesfully saved!'
        ]);
    }

    public function deleteSavedProduct(Request $request, $productId)
    {
        $product = Product::findOrFail($productId);
        $user = $this->user();

        $user->saved_products()->detach($product->id);
        $user->save();

        return response()->json([
            'message' => 'Product succesfully removed!'
        ]);
    }
}
