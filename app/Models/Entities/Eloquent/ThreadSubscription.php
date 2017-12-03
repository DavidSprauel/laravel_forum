<?php

namespace Forum\Models\Entities\Eloquent;

use Forum\Notifications\ThreadWasUpdated;
use Illuminate\Database\Eloquent\Model;

class ThreadSubscription extends Model
{
    protected $guarded = [];
    
    public function user() {
        return $this->belongsTo(User::class);
    }
    
    public function notify($reply) {
        $this->user->notify(new ThreadWasUpdated($this->thread, $reply));
    }
    
    public function thread() {
        return $this->belongsTo(Thread::class);
    }
}
