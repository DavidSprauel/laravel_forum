<?php


namespace Forum\Models\Business;


use Forum\Models\DataAccess\Read\Thread as ThreadRead;
use Forum\Models\DataAccess\Write\Thread as ThreadWrite;
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
    
    public function latestWithFilter(Channel $channel = null, $filters) {
        return $this->read->latestWithFilter($channel, $filters);
    }
    
    public function delete(ThreadModel $thread) {
        $this->write->delete($thread);
    
        if(request()->wantsJson()) {
            return response([], 204);
        }
        
        return redirect('/threads');
    }
    
}