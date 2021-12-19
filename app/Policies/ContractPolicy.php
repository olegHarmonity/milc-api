<?php
namespace App\Policies;

use App\Models\Contract;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use App\Util\AuthorizationResponses;
use App\Util\UserRoles;
use Illuminate\Auth\Access\Response;

class ContractPolicy
{
    use HandlesAuthorization;

    public function view(User $user, Contract $contract)
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
        
        if(!$contract->seller && !$contract->buyer){
            return Response::deny(AuthorizationResponses::$NOT_ALLOWED);
        }
        
        if($contract->seller->id === $user->organisation->id){
            return true;
        }
        
        if($contract->buyer->id === $user->organisation->id){
            return true;
        }
        
        return Response::deny(AuthorizationResponses::$NOT_ALLOWED);
    }
    
    public function viewAny(User $user)
    {
        if (! $user) {
            return Response::deny(AuthorizationResponses::$NOT_ALLOWED);
        }

        if ($user->role === UserRoles::$ROLE_ADMIN) {
            return true;
        }

        if (! $user->organisation) {
            return Response::deny(AuthorizationResponses::$NOT_ALLOWED);
        }

        return true;
    }

    public function viewAdminDefault(User $user)
    {
        if (! $user) {
            return Response::deny(AuthorizationResponses::$NOT_ALLOWED);
        }

        if ($user->role === UserRoles::$ROLE_ADMIN) {
            return true;
        }

        return Response::deny(AuthorizationResponses::$NOT_ALLOWED);
    }

    public function viewOrganisationDefault(User $user, Contract $contract)
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
        
        if(!$contract->seller){
            return Response::deny(AuthorizationResponses::$NOT_ALLOWED);
        }
        
        if($contract->seller->id === $user->organisation->id){
            return true;
        }
   
        return Response::deny(AuthorizationResponses::$NOT_ALLOWED);
    }

    /**
     * Determine whether the user can create models.
     *
     * @param \App\Models\User $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Contract $contract
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Contract $contract)
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Contract $contract
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Contract $contract)
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Contract $contract
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Contract $contract)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\Contract $contract
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Contract $contract)
    {
        //
    }
}
