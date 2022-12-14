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
    
    public function addProduct(User $user, User $model)
    {
        if (! $user) {
            return Response::deny(AuthorizationResponses::$NOT_ALLOWED);
        }
        
        if (! $user->organisation) {
            return Response::deny(AuthorizationResponses::$NOT_ALLOWED);
        }
        
        if (! $user->is_from_seller_organisation()) {
            return Response::deny(AuthorizationResponses::$NOT_ALLOWED);
        }
        
        return true;
    }
    
    public function buyProduct(User $user, User $model)
    {
        if (! $user) {
            return Response::deny(AuthorizationResponses::$NOT_ALLOWED);
        }
        
        if (! $user->organisation) {
            return Response::deny(AuthorizationResponses::$NOT_ALLOWED);
        }
        
        if (! $user->is_from_buyer_organisation()) {
            return Response::deny(AuthorizationResponses::$NOT_ALLOWED);
        }
        
        return true;
    }
    

    public function create(User $user)
    {
        return $user->isCompanyAdmin(true);
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

    public function viewByUser(User $user, User $userActivityUser)
    {
        if (!$user) {
            return Response::deny(AuthorizationResponses::$NOT_ALLOWED);
        }

        if ($user->role === UserRoles::$ROLE_ADMIN) {
            return true;
        }

        if ($user->id === $userActivityUser->id) {
            return true;
        }

        if (!$user->organisation) {
            return Response::deny(AuthorizationResponses::$NOT_ALLOWED);
        }

        if ($user->role !== UserRoles::$ROLE_COMPANY_ADMIN) {
            return Response::deny(AuthorizationResponses::$NOT_ALLOWED);
        }

        if ($user->company_id !== $userActivityUser->company_id) {
            return Response::deny(AuthorizationResponses::$NOT_ALLOWED);
        }

        return true;
    }
}
