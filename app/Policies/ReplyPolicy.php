<?php

namespace Forum\Policies;

use Forum\Models\Entities\Eloquent\Reply;
use Forum\Models\Entities\Eloquent\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ReplyPolicy
{
    use HandlesAuthorization;
    
    public function update(User $user, Reply $reply) {
        return $reply->user_id == $user->id;
    }
    
}
