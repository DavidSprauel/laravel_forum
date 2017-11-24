<?php

namespace Forum\Models\Entities\Eloquent;

use Forum\Models\Traits\Favoritable;
use Forum\Models\Traits\RecordsActivity;
use Illuminate\Database\Eloquent\Model;

class Reply extends Model {
    
    use Favoritable, RecordsActivity;
    
    protected $guarded = [];
    protected $with = ['owner', 'favorites'];
    
    public function owner() {
        return $this->belongsTo(User::class, 'user_id');
    }
    
}
