<?php

namespace App\Policies;

use App\Models\Person;
use App\Models\User;
use App\Util\AuthorizationResponses;
use App\Util\CompanyRoles;
use App\Util\UserRoles;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class PersonPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        return true;
    }

    public function view(User $user, Person $person)
    {
        return true;
    }

    public function create(User $user)
    {
        return $user && $user->isAdmin();
    }

    public function update(User $user, Person $person)
    {
        return $user && $user->isAdmin();
    }

    public function delete(User $user, Person $person)
    {
        return $user && $user->isAdmin();
    }

    public function restore(User $user, Person $person)
    {
        return $user && $user->isAdmin();
    }

    public function forceDelete(User $user, Person $person)
    {
        return $user && $user->isAdmin();
    }
}
