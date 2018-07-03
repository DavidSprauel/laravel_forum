<?php

namespace Forum\Models\Entities\Eloquent;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model {
    
    protected $guarded = [];
    
    public function subject() {
        return $this->morphTo();
    }
    
    public static function feed(User $user, $take = 50): Collection{
        return static::where('user_id', $user->id)
            ->latest()
            ->with('subject')
            ->take($take)
            ->get()
            ->groupBy(function($activity) {
                return $activity->created_at->format('l jS Y');
            });
    }
}
