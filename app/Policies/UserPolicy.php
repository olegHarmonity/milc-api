<?php

namespace App\Policies;

use App\Models\User;
use App\Util\AuthorizationResponses;
use App\Util\UserRoles;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class UserPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        if (!$user) {
            return Response::deny(AuthorizationResponses::$NOT_ALLOWED);
        }

        return $user->role === UserRoles::$ROLE_ADMIN
            ? true
            : Response::deny(AuthorizationResponses::$NOT_ALLOWED);
    }

    public function me(User $user)
    {
        if (!$user) {
            return Response::deny(AuthorizationResponses::$NOT_ALLOWED);
        }

        return true;
    }

    public function view(User $user, User $model)
    {
        if (!$user) {
            return Response::deny(AuthorizationResponses::$NOT_ALLOWED);
        }
        return ($user->id === $model->id) or ($user->role === UserRoles::$ROLE_ADMIN)
            ? true
            : Response::deny(AuthorizationResponses::$NOT_ALLOWED);
    }

    public function create(User $user)
    {
        return true;
    }

    public function update(User $user, User $model)
    {
        return $user->id === $model->id ||
            $user->isAdmin() ||
            ($user->isCompanyAdmin() && $user->organisation_id === $model->organisation_id);
    }

    public function delete(User $user, User $model)
    {
        if ($user->isAdmin()) {
            return true;
        }

        if (!$user->isCompanyAdmin()) {
            return false;
        }

        if ($user->id == $model->id) {
            return false;
        }

        return $user->organisation_id == $model->organisation_id;
    }

    public function restore(User $user, User $model)
    {
        if (!$user) {
            return Response::deny(AuthorizationResponses::$NOT_ALLOWED);
        }

        return $user->role === UserRoles::$ROLE_ADMIN
            ? true
            : Response::deny(AuthorizationResponses::$NOT_ALLOWED);
    }

    public function forceDelete(User $user, User $model)
    {
        if (!$user) {
            return Response::deny(AuthorizationResponses::$NOT_ALLOWED);
        }

        return $user->role === UserRoles::$ROLE_ADMIN
            ? true
            : Response::deny(AuthorizationResponses::$NOT_ALLOWED);
    }
}
