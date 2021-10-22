<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\RegisterUserRequest;
use App\Http\Resources\User\UserResource;
use App\Models\User;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    public function me()
    {
        return response()->json(auth()->user());
    }

    public function register(RegisterUserRequest $request)
    {
        $userRequest = $request->all();

        $user = User::create($userRequest);

        return (new UserResource($user))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }
}
