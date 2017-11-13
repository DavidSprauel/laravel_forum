<?php


namespace Forum\Models\Business;


use Forum\Models\DataAcces\Read\Thread as ThreadRead;
use Forum\Models\DataAcces\Write\Thread as ThreadWrite;
use Forum\Models\Entities\Eloquent\Channel;
use Forum\Models\Entities\Eloquent\Thread as ThreadModel;

class Thread extends BaseBusiness {
    
    public function __construct() {
        $this->read = new ThreadRead();
        $this->write = new ThreadWrite();
    }
    
    
    public function addReply(ThreadModel $thread, array $request) {
        return $this->write->addReply($thread, $request);
    }
    
    public function create($fields) {
        return $this->write->create($fields);
    }
    
    public function latest(Channel $channel = null) {
        return $this->read->latest($channel);
    }


    
}