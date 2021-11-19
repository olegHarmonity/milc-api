<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use App\Models\Email;
use App\Util\AuthorizationResponses;
use App\Util\UserRoles;
use Illuminate\Auth\Access\Response;

class EmailPolicy
{
    use HandlesAuthorization;
    
    
    public function send(User $user)
    {
        if (!$user) {
            return Response::deny(AuthorizationResponses::$NOT_ALLOWED);
        }
        
        return $user->role === UserRoles::$ROLE_ADMIN
        ? true
        : Response::deny(AuthorizationResponses::$NOT_ALLOWED);
    }
}
