<?php

namespace Forum\Policies;

use Forum\Models\Entities\Eloquent\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;
    
    public function update(User $requester, User $user) {
        return $user->id === $requester->id;
    }
}
