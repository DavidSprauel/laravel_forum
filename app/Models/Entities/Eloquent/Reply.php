<?php

namespace Forum\Models\Entities\Eloquent;

use Forum\Models\Traits\Favoritable;
use Illuminate\Database\Eloquent\Model;

class Reply extends Model {
    
    use Favoritable;
    
    protected $guarded = [];
    protected $with = ['owner', 'favorites'];
    
    public function owner() {
        return $this->belongsTo(User::class, 'user_id');
    }
    
}
