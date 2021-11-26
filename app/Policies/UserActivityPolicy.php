<?php

namespace App\Policies;

use App\Models\User;
use App\Models\UserActivity;
use Illuminate\Auth\Access\HandlesAuthorization;
use App\Util\AuthorizationResponses;
use App\Util\UserRoles;
use Illuminate\Auth\Access\Response;

class UserActivityPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
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
        
        if ($user->role !== UserRoles::$ROLE_COMPANY_ADMIN) {
            return Response::deny(AuthorizationResponses::$NOT_ALLOWED);
        }
        
        return true;
    }

    public function view(User $user, UserActivity $userActivity)
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
        
        if ($user->id !== $userActivity->user->id) {
            return Response::deny(AuthorizationResponses::$NOT_ALLOWED);
        }
        
        if ($user->role !== UserRoles::$ROLE_COMPANY_ADMIN) {
            return Response::deny(AuthorizationResponses::$NOT_ALLOWED);
        }
        
        return true;
    }
}
