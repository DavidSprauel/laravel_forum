<?php


namespace Forum\Models\Business;


use Forum\Models\Entities\Eloquent\Thread;

class ThreadSubscription extends BaseBusiness {
    
    public function __construct() {
        $this->read = new \Forum\Models\DataAccess\Read\ThreadSubscription();
        $this->write = new \Forum\Models\DataAccess\Write\ThreadSubscription();
    }
    
    public function subscribe(Thread $thread) {
        return $this->write->subscribe($thread);
    }
    
    public function unsubscribe(Thread $thread) {
        return $this->write->unsubscribe($thread);
    }
}