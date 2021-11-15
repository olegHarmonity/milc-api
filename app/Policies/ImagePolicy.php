<?php

namespace App\Policies;

use App\Models\Image;
use App\Models\User;
use App\Util\AuthorizationResponses;
use App\Util\UserRoles;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class ImagePolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        return true;
    }

    public function view(User $user, Image $image)
    {
        return true;
    }

    public function create(User $user)
    {
        if (!$user) {
            return Response::deny(AuthorizationResponses::$NOT_ALLOWED);
        }

        if ($user->role === UserRoles::$ROLE_ADMIN) {
            return true;
        }

        if (!$user->organisation()) {
            return Response::deny(AuthorizationResponses::$NOT_ALLOWED);
        }

        if (!$user->is_from_seller_organisation()) {
            return Response::deny(AuthorizationResponses::$NOT_ALLOWED);
        }

        return  Response::deny(AuthorizationResponses::$NOT_ALLOWED);
    }

    public function update(User $user, Image $image)
    {
        return Response::deny(AuthorizationResponses::$NOT_ALLOWED);
    }

    public function delete(User $user, Image $image)
    {
        if (!$user) {
            return Response::deny(AuthorizationResponses::$NOT_ALLOWED);
        }

        if ($user->role === UserRoles::$ROLE_ADMIN) {
            return true;
        }

        if (!$user->organisation()) {
            return Response::deny(AuthorizationResponses::$NOT_ALLOWED);
        }

        if (!$user->is_from_seller_organisation()) {
            return Response::deny(AuthorizationResponses::$NOT_ALLOWED);
        }

        return Response::deny(AuthorizationResponses::$NOT_ALLOWED);
    }

    public function restore(User $user, Image $image)
    {
        if (!$user) {
            return Response::deny(AuthorizationResponses::$NOT_ALLOWED);
        }

        return $user->role === UserRoles::$ROLE_ADMIN
            ? true
            : Response::deny(AuthorizationResponses::$NOT_ALLOWED);
    }

    public function forceDelete(User $user, Image $image)
    {
        if (!$user) {
            return Response::deny(AuthorizationResponses::$NOT_ALLOWED);
        }

        return $user->role === UserRoles::$ROLE_ADMIN
            ? true
            : Response::deny(AuthorizationResponses::$NOT_ALLOWED);
    }
}
