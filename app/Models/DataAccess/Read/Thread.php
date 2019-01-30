<?php


namespace Forum\Models\DataAccess\Read;


use Forum\Models\Entities\Eloquent\Channel;
use Forum\Models\Entities\Eloquent\Thread as ThreadModel;

class Thread  extends BaseReader {
    
    public function __construct() {
        $this->model = ThreadModel::class;
    }
    
    public function latestWithFilter(Channel $channel = null, $filters) {
        $threads = $this->model::latest()->filter($filters);
        
        if(!is_null($channel)) {
            $threads = $threads->where('channel_id', $channel->id);
        }
        
        return $threads->paginate(25);
    }

    public function search($query)
    {
        return $this->model::search($query)->paginate(25);
    }
    
}