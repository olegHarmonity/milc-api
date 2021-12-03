<?php
namespace App\Policies;

use App\Models\Order;
use App\Models\User;
use App\Util\AuthorizationResponses;
use App\Util\UserRoles;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Http\Client\Response;

class OrderPolicy
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
    
    public function view(User $user, Order $order)
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
        
        if($order->organisation->id === $user->organisation->id){
            return true;
        }
        
        if($order->rights_bundle->product->organisation->id === $user->organisation->id){
            return true;
        }
        
        return Response::deny(AuthorizationResponses::$NOT_ALLOWED);
    }

    public function create(User $user)
    {
        
        if (! $user) {
            return Response::deny(AuthorizationResponses::$NOT_ALLOWED);
        }
        
        if (!$user->organisation) {
            return Response::deny(AuthorizationResponses::$NOT_ALLOWED);
        }
        
        if(!$user->is_from_buyer_organisation()){
            return Response::deny(AuthorizationResponses::$NOT_ALLOWED);
        }
        
        return true;
    }

    public function update(User $user, Order $order)
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
        
        if($order->organisation->id === $user->organisation->id){
            return true;
        }
        
        if($order->rights_bundle->product->organisation->id === $user->organisation->id){
            return true;
        }
        
        return Response::deny(AuthorizationResponses::$NOT_ALLOWED);
    }

    public function delete(User $user, Order $order)
    {
        if (! $user) {
            return Response::deny(AuthorizationResponses::$NOT_ALLOWED);
        }
        
        if ($user->role === UserRoles::$ROLE_ADMIN) {
            return true;
        }
        
        return Response::deny(AuthorizationResponses::$NOT_ALLOWED);
    }

    public function restore(User $user, Order $order)
    {
        if (! $user) {
            return Response::deny(AuthorizationResponses::$NOT_ALLOWED);
        }
        
        if ($user->role === UserRoles::$ROLE_ADMIN) {
            return true;
        }
        
        return Response::deny(AuthorizationResponses::$NOT_ALLOWED);
    }

    public function forceDelete(User $user, Order $order)
    {
        if (! $user) {
            return Response::deny(AuthorizationResponses::$NOT_ALLOWED);
        }
        
        if ($user->role === UserRoles::$ROLE_ADMIN) {
            return true;
        }
        
        return Response::deny(AuthorizationResponses::$NOT_ALLOWED);
    }
}
