<?php
namespace App\Policies;

use App\Models\Feedback;
use App\Models\User;
use App\Util\AuthorizationResponses;
use App\Util\UserRoles;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class FeedbackPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        return true;
    }


    public function view(User $user, Feedback $feedback)
    {
        return $user->role === UserRoles::$ROLE_ADMIN ? true : Response::deny(AuthorizationResponses::$NOT_ALLOWED);
    }

    public function create(User $user)
    {
        return true;
    }

    public function update(User $user, Feedback $feedback)
    {
        return $user->role === UserRoles::$ROLE_ADMIN ? true : Response::deny(AuthorizationResponses::$NOT_ALLOWED);
    }

    public function delete(User $user, Feedback $feedback)
    {
        return $user->role === UserRoles::$ROLE_ADMIN ? true : Response::deny(AuthorizationResponses::$NOT_ALLOWED);
    }
}
