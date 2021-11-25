<?php
namespace App\Policies;

use App\Models\Product;
use App\Models\User;
use App\Util\AuthorizationResponses;
use App\Util\UserRoles;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class ProductPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        return true;
    }

    public function view(User $user, Product $product)
    {
        return true;
    }

    public function create(User $user)
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

    public function update(User $user, Product $product)
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

        if ($user->organisation->id !== $product->organisation->id) {
            return Response::deny(AuthorizationResponses::$NOT_ALLOWED);
        }

        return true;
    }

    public function delete(User $user, Product $product)
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

        if (! $user->is_from_seller_organisation()) {
            return Response::deny(AuthorizationResponses::$NOT_ALLOWED);
        }

        if ($user->organisation->id !== $product->organisation->id) {
            return Response::deny(AuthorizationResponses::$NOT_ALLOWED);
        }

        return true;
    }

    public function updateStatus(User $user, Product $product)
    {
        if (! $user) {
            return Response::deny(AuthorizationResponses::$NOT_ALLOWED);
        }

        if ($user->role !== UserRoles::$ROLE_ADMIN) {
            return Response::deny(AuthorizationResponses::$NOT_ALLOWED);
        }

        return true;
    }

    public function restore(User $user, Product $product)
    {
        if (! $user) {
            return Response::deny(AuthorizationResponses::$NOT_ALLOWED);
        }

        if ($user->role !== UserRoles::$ROLE_ADMIN) {
            return Response::deny(AuthorizationResponses::$NOT_ALLOWED);
        }

        return true;
    }
}
