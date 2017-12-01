<?php

namespace Forum\Models\Entities\Eloquent;

use Forum\Models\Traits\RecordsActivity;
use Illuminate\Database\Eloquent\Model;

class Favorite extends Model {
    
    use RecordsActivity;
    
    protected $guarded = [];
    
    
    public function favorited() {
        return $this->morphTo();
    }
   
}
