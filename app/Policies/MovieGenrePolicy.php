<?php

namespace App\Policies;

use App\Models\MovieGenre;
use App\Models\User;
use App\Util\AuthorizationResponses;
use App\Util\UserRoles;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class MovieGenrePolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        return true;
    }

    public function view(User $user, MovieGenre $movieGenre)
    {
        return true;
    }

    public function create(User $user)
    {
        if (!$user) {
            return Response::deny(AuthorizationResponses::$NOT_ALLOWED);
        }

        return $user->role === UserRoles::$ROLE_ADMIN
            ? true
            : Response::deny(AuthorizationResponses::$NOT_ALLOWED);
    }

    public function update(User $user, MovieGenre $movieGenre)
    {
        if (!$user) {
            return Response::deny(AuthorizationResponses::$NOT_ALLOWED);
        }

        return $user->role === UserRoles::$ROLE_ADMIN
            ? true
            : Response::deny(AuthorizationResponses::$NOT_ALLOWED);
    }

    public function delete(User $user, MovieGenre $movieGenre)
    {
        if (!$user) {
            return Response::deny(AuthorizationResponses::$NOT_ALLOWED);
        }

        return $user->role === UserRoles::$ROLE_ADMIN
            ? true
            : Response::deny(AuthorizationResponses::$NOT_ALLOWED);
    }

    public function restore(User $user, MovieGenre $movieGenre)
    {
        if (!$user) {
            return Response::deny(AuthorizationResponses::$NOT_ALLOWED);
        }

        return $user->role === UserRoles::$ROLE_ADMIN
            ? true
            : Response::deny(AuthorizationResponses::$NOT_ALLOWED);
    }

    public function forceDelete(User $user, MovieGenre $movieGenre)
    {
        if (!$user) {
            return Response::deny(AuthorizationResponses::$NOT_ALLOWED);
        }

        return $user->role === UserRoles::$ROLE_ADMIN
            ? true
            : Response::deny(AuthorizationResponses::$NOT_ALLOWED);
    }
}
