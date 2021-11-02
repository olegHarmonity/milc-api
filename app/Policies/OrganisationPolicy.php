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

    /**
     * Determine whether the user can view any models.
     *
     * @param \App\Models\User $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        if (!$user) {
            return Response::deny(AuthorizationResponses::$NOT_ALLOWED);
        }

        return $user->role === UserRoles::$ROLE_ADMIN
            ? true
            : Response::deny(AuthorizationResponses::$NOT_ALLOWED);
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Organisation $organisation
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Organisation $organisation)
    {
        if (!$user) {
            return Response::deny(AuthorizationResponses::$NOT_ALLOWED);
        }

        return ($organisation->hasUser($user)) or ($user->role === UserRoles::$ROLE_ADMIN)
                ? true
                : Response::deny(AuthorizationResponses::$NOT_ALLOWED);
    }

    /**
     * Determine whether the user can create models.
     *
     * @param \App\Models\User $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Organisation $organisation
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Organisation $organisation)
    {
        if (!$user) {
            return Response::deny(AuthorizationResponses::$NOT_ALLOWED);
        }

        return ($organisation->hasUser($user) and $user->role === UserRoles::$ROLE_COMPANY_ADMIN)
            or ($user->role === UserRoles::$ROLE_ADMIN)
                ? true
                : Response::deny(AuthorizationResponses::$NOT_ALLOWED);
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Organisation $organisation
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Organisation $organisation)
    {
        if (!$user) {
            return Response::deny(AuthorizationResponses::$NOT_ALLOWED);
        }

        return $user->role === UserRoles::$ROLE_ADMIN
            ? true
            : Response::deny(AuthorizationResponses::$NOT_ALLOWED);
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Organisation $organisation
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Organisation $organisation)
    {
        if (!$user) {
            return Response::deny(AuthorizationResponses::$NOT_ALLOWED);
        }

        return $user->role === UserRoles::$ROLE_ADMIN
            ? true
            : Response::deny(AuthorizationResponses::$NOT_ALLOWED);
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Organisation $organisation
     * @return \Illuminate\Auth\Access\Response|bool
     */
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
