<?php

namespace Forum\Models\Entities\Eloquent;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable {
    
    use Notifiable;
    
    protected $fillable = [
        'name', 'email', 'password',
    ];
    
    protected $hidden = [
        'password', 'remember_token',
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
}
