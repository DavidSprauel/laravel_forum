<?php

namespace Forum\Models\Entities\Eloquent;

use Forum\Library\Visits;
use Forum\Models\Traits\RecordsActivity;
use Illuminate\Database\Eloquent\Model;

class Thread extends Model {
    
    use RecordsActivity;
    
    protected $guarded = [];
    protected $with = ['creator', 'channel'];
    protected $appends = ['isSubscribedTo'];
    
    protected static function boot() {
        parent::boot();
        
        static::deleting(function ($thread) {
            $thread->replies->each->delete();
        });
    }
    
    public function path() {
        return "/threads/{$this->channel->slug}/{$this->id}";
    }
    
    public function replies() {
        return $this->hasMany(Reply::class);
    }
    
    public function creator() {
        return $this->belongsTo(User::class, 'user_id');
    }
    
    public function channel() {
        return $this->belongsTo(Channel::class);
    }
    
    public function scopeFilter($query, $filters) {
        return $filters->apply($query);
    }
    
    public function subscriptions() {
        return $this->hasMany(ThreadSubscription::class);
    }
    
    public function getIsSubscribedToAttribute($userId = null) {
        return $this->subscriptions()
            ->where('user_id', $userId ? : auth()->id())
            ->exists();
    }
    
    public function subscribe($userId = null) {
        $this->subscriptions()->create([
            'user_id' => $userId ? : auth()->id(),
        ]);
        
        return $this;
    }
    
    public function unsubscribe($userId = null) {
        return $this->subscriptions()
            ->where('user_id', $userId ? : auth()->id())
            ->delete();
    }
    
    public function hasUpdatesFor($user = null) {
        return $this->updated_at > cache($user->visitedCacheKey($this));
    }
    
    public function visits() {
        return new Visits($this);
    }
    
}
