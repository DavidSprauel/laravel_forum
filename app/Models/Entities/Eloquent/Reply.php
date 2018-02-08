<?php

namespace Forum\Models\Entities\Eloquent;

use Carbon\Carbon;
use Forum\Models\Traits\Favoritable;
use Forum\Models\Traits\RecordsActivity;
use Illuminate\Database\Eloquent\Model;

class Reply extends Model {
    
    use Favoritable, RecordsActivity;
    
    protected $guarded = [];
    protected $with = ['owner', 'favorites'];
    protected $appends = ['favoritesCount', 'isFavorited'];
    
    protected static function boot() {
        parent::boot();
        
        static::created(function($reply) {
            $reply->thread->increment('replies_count');
    
            $reply->thread->subscriptions
                ->where('user_id', '!=', $reply->user_id)
                ->each->notify($reply);
        });
    
        static::deleted(function($reply) {
            $reply->thread->decrement('replies_count');
        });
    }
    
    public function owner() {
        return $this->belongsTo(User::class, 'user_id');
    }
    
    public function thread() {
        return $this->belongsTo(Thread::class);
    }
    
    public function path() {
        return $this->thread->path() . "#reply-{$this->id}";
    }
    
    public function wasJustPublished() {
        return $this->created_at->gt(Carbon::now()->subMinute());
    }
    
}
