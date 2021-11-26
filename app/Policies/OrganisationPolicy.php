<?php

namespace App\Policies;

use App\Models\Organisation;
use App\Models\User;
use App\Util\AuthorizationResponses;
use App\Util\UserRoles;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class OrganisationPolicy
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

    public function view(User $user, Organisation $organisation)
    {
        if (!$user) {
            return Response::deny(AuthorizationResponses::$NOT_ALLOWED);
        }

        return ($organisation->hasUser($user)) or ($user->role === UserRoles::$ROLE_ADMIN)
                ? true
                : Response::deny(AuthorizationResponses::$NOT_ALLOWED);
    }

    public function create(User $user)
    {
        return true;
    }

    public function update(User $user, Organisation $organisation)
    {
        if (!$user) {
            return Response::deny(AuthorizationResponses::$NOT_ALLOWED);
        }

        if ($user->role === UserRoles::$ROLE_ADMIN ) {
            return true;
        }

        if (!$user->organisation) {
            return Response::deny(AuthorizationResponses::$NOT_ALLOWED);
        }

        if ($user->organisation()->first()->id !== $organisation->id) {
            return Response::deny(AuthorizationResponses::$NOT_ALLOWED);
        }

        if (!in_array($user->role, [UserRoles::$ROLE_COMPANY_ADMIN, UserRoles::$ROLE_ADMIN]) ) {
            return Response::deny(AuthorizationResponses::$NOT_ALLOWED);
        }

        return true;
    }
    
    public function updateStatus(User $user, Organisation $organisation)
    {
        if (! $user) {
            return Response::deny(AuthorizationResponses::$NOT_ALLOWED);
        }
        
        if ($user->role !== UserRoles::$ROLE_ADMIN) {
            return Response::deny(AuthorizationResponses::$NOT_ALLOWED);
        }
        
        return true;
    }

    public function delete(User $user, Organisation $organisation)
    {
        if (!$user) {
            return Response::deny(AuthorizationResponses::$NOT_ALLOWED);
        }

        return $user->role === UserRoles::$ROLE_ADMIN
            ? true
            : Response::deny(AuthorizationResponses::$NOT_ALLOWED);
    }

    public function restore(User $user, Organisation $organisation)
    {
        if (!$user) {
            return Response::deny(AuthorizationResponses::$NOT_ALLOWED);
        }

        return $user->role === UserRoles::$ROLE_ADMIN
            ? true
            : Response::deny(AuthorizationResponses::$NOT_ALLOWED);
    }

    public function forceDelete(User $user, Organisation $organisation)
    {
        if (!$user) {
            return Response::deny(AuthorizationResponses::$NOT_ALLOWED);
        }

        return $user->role === UserRoles::$ROLE_ADMIN
            ? true
            : Response::deny(AuthorizationResponses::$NOT_ALLOWED);
    }
}
