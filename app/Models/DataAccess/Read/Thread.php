<?php


namespace Forum\Models\DataAcces\Read;


use Forum\Models\Entities\Eloquent\Channel;
use Forum\Models\Entities\Eloquent\Thread as ThreadModel;

class Thread  extends BaseReader {
    
    public function __construct() {
        $this->model = ThreadModel::class;
    }
    
    public function latest(Channel $channel = null) {
        $threads =  $this->model::latest();
        
        if(!is_null($channel)) {
            $threads = $channel->threads()->latest();
        }
        
        return $threads->get();
    }
    
}