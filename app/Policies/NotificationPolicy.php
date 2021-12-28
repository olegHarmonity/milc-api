<?php

namespace App\Policies;

use App\Models\Notification;
use Illuminate\Auth\Access\Response;
use App\Models\User;
use App\Util\AuthorizationResponses;
use App\Util\UserRoles;
use Illuminate\Auth\Access\HandlesAuthorization;

class NotificationPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        if (! $user) {
            return Response::deny(AuthorizationResponses::$NOT_ALLOWED);
        }
        
        if ($user->role === UserRoles::$ROLE_ADMIN) {
            return true;
        }
        
        if (!$user->organisation) {
            return Response::deny(AuthorizationResponses::$NOT_ALLOWED);
        }
        
        return true;
    }

    public function view(User $user, Notification $notification)
    {
        if (! $user) {
            return Response::deny(AuthorizationResponses::$NOT_ALLOWED);
        }
        
        if ($user->role === UserRoles::$ROLE_ADMIN) {
            return true;
        }
        
        if (!$user->organisation) {
            return Response::deny(AuthorizationResponses::$NOT_ALLOWED);
        }
        
        if ($user->organisation_id !== $notification->organisation_id) {
            return Response::deny(AuthorizationResponses::$NOT_ALLOWED);
        }
        
        return true;
    }

    public function markAsRead(User $user, Notification $notification)
    {
        if (! $user) {
            return Response::deny(AuthorizationResponses::$NOT_ALLOWED);
        }
        
        if ($user->role === UserRoles::$ROLE_ADMIN) {
            return true;
        }
        
        if (!$user->organisation) {
            return Response::deny(AuthorizationResponses::$NOT_ALLOWED);
        }
        
        if ($user->organisation_id !== $notification->organisation_id) {
            return Response::deny(AuthorizationResponses::$NOT_ALLOWED);
        }
        
        return true;
    }

    public function delete(User $user, Notification $notification)
    {
        if (! $user) {
            return Response::deny(AuthorizationResponses::$NOT_ALLOWED);
        }
        
        if ($user->role === UserRoles::$ROLE_ADMIN) {
            return true;
        }
        
        if (!$user->organisation) {
            return Response::deny(AuthorizationResponses::$NOT_ALLOWED);
        }
        
        if ($user->organisation_id !== $notification->organisation_id) {
            return Response::deny(AuthorizationResponses::$NOT_ALLOWED);
        }
        
        return true;
    }
}
