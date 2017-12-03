<?php


namespace Forum\Models\DataAccess\Write;


use Forum\Models\Entities\Eloquent\Thread;

class ThreadSubscription extends BaseWriter {
    
    public function __construct() {
        $this->model = \Forum\Models\Entities\Eloquent\ThreadSubscription::class;
    }
    
    public function subscribe(Thread $thread) {
        return $thread->subscribe();
    }
    
    public function unsubscribe(Thread $thread) {
        return $thread->unsubscribe();
    }
    
    
}