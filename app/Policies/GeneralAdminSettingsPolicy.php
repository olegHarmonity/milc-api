<?php

namespace App\Policies;

use App\Models\GeneralAdminSettings;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use App\Util\AuthorizationResponses;
use App\Util\UserRoles;
use Illuminate\Auth\Access\Response;

class GeneralAdminSettingsPolicy
{
    use HandlesAuthorization;

    public function view(User $user, GeneralAdminSettings $generalAdminSettings)
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

    public function update(User $user, GeneralAdminSettings $generalAdminSettings)
    {
        if (!$user) {
            return Response::deny(AuthorizationResponses::$NOT_ALLOWED);
        }
        
        return $user->role === UserRoles::$ROLE_ADMIN
        ? true
        : Response::deny(AuthorizationResponses::$NOT_ALLOWED);
    }
}
