<?php

namespace App\Policies;

use App\Models\File;
use App\Models\User;
use App\Util\AuthorizationResponses;
use App\Util\CompanyRoles;
use App\Util\UserRoles;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class FilePolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        return true;
    }

    public function view(User $user, File $file)
    {
        return true;
    }

    public function create(User $user)
    {
        if (!$user) {
            return Response::deny(AuthorizationResponses::$NOT_ALLOWED);
        }

        if (!$user->organisation()) {
            return Response::deny(AuthorizationResponses::$NOT_ALLOWED);
        }

        if (!$user->is_from_seller_organisation()) {
            return Response::deny(AuthorizationResponses::$NOT_ALLOWED);
        }

        return $user->role === UserRoles::$ROLE_ADMIN
            ? true
            : Response::deny(AuthorizationResponses::$NOT_ALLOWED);
    }

    public function update(User $user, File $file)
    {
        return Response::deny(AuthorizationResponses::$NOT_ALLOWED);
    }

    public function delete(User $user, File $file)
    {
        if (!$user) {
            return Response::deny(AuthorizationResponses::$NOT_ALLOWED);
        }

        if (!$user->organisation()) {
            return Response::deny(AuthorizationResponses::$NOT_ALLOWED);
        }

        if (!$user->is_from_seller_organisation()) {
            return Response::deny(AuthorizationResponses::$NOT_ALLOWED);
        }

        return $user->role === UserRoles::$ROLE_ADMIN
            ? true
            : Response::deny(AuthorizationResponses::$NOT_ALLOWED);
    }

    public function restore(User $user, File $file)
    {
        if (!$user) {
            return Response::deny(AuthorizationResponses::$NOT_ALLOWED);
        }

        return $user->role === UserRoles::$ROLE_ADMIN
            ? true
            : Response::deny(AuthorizationResponses::$NOT_ALLOWED);
    }

    public function forceDelete(User $user, File $file)
    {
        if (!$user) {
            return Response::deny(AuthorizationResponses::$NOT_ALLOWED);
        }

        return $user->role === UserRoles::$ROLE_ADMIN
            ? true
            : Response::deny(AuthorizationResponses::$NOT_ALLOWED);
    }
}
