<?php

namespace Forum\Models\Entities\Eloquent;

use Illuminate\Database\Eloquent\Model;

class Channel extends Model {
    
    public function getRouteKeyName() {
        return 'slug';
    }
    
    public function threads() {
        return $this->hasMany(Thread::class);
    }
}
