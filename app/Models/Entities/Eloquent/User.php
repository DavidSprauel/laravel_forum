<?php

namespace Forum\Models\Entities\Eloquent;

use Carbon\Carbon;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable {
    
    use Notifiable;
    
    protected $fillable = [
        'name', 'email', 'password', 'avatar_path'
    ];
    
    protected $hidden = [
        'password', 'remember_token', 'email'
    ];
    
    public function getRouteKeyName() {
        return 'name';
    }
    
    public function threads() {
        return $this->hasMany(Thread::class)->latest();
    }
    
    public function profilePath() {
        return '/profiles/'.$this->name;
    }
    
    public function activity() {
        return $this->hasMany(Activity::class);
    }
    
    public function getLatestActivities() {
        return $this->activity()
            ->latest()
            ->with('subject')
            ->take(50)
            ->get()
            ->groupBy(function($activity){
                return $activity->created_at->format('Y-m-d');
            });
    }
    
    public function visitedCacheKey($thread) {
        return sprintf('users.%s.visists.%s', $this->id, $thread->id);
    }
    
    public function read($thread) {
        cache()->forever($this->visitedCacheKey($thread), Carbon::now());
    }
    
    public function lastReply() {
        return $this->hasOne(Reply::class)->latest();
    }
    
    public function getAvatarPathAttribute($avatar) {
        return asset($avatar ?? 'avatars/default.png');
    }
}
