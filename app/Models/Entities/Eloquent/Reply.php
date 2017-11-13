<?php

namespace Forum\Models\Entities\Eloquent;

use Illuminate\Database\Eloquent\Model;

class Reply extends Model {
    
    protected $guarded = [];
    
    public function owner() {
        return $this->belongsTo(User::class, 'user_id');
    }
}
