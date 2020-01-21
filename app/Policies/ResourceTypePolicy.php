<?php

namespace App\Policies;

use App\User;
use App\ResourceType;
use Illuminate\Auth\Access\HandlesAuthorization;

class ResourceTypePolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function update(User $user, ResourceType $resourceType) 
    {
        return true;
    }
}
