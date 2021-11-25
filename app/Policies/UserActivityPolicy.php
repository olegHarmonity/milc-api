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
        
        return $user->role === UserRoles::$ROLE_ADMIN
        ? true
        : Response::deny(AuthorizationResponses::$NOT_ALLOWED);
    }

    public function view(User $user, UserActivity $userActivity)
    {
        if (!$user) {
            return Response::deny(AuthorizationResponses::$NOT_ALLOWED);
        }
        
        return $user->role === UserRoles::$ROLE_ADMIN
        ? true
        : Response::deny(AuthorizationResponses::$NOT_ALLOWED);
    }
}
