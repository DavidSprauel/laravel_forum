<?php


namespace Forum\Library;


use Redis;

class Visits {
    
    protected $thread;
    
    public function __construct($thread) {
        $this->thread = $thread;
    }
    
    public function reset() {
        Redis::del($this->cacheKey());
    
        return $this;
    }
    
    public function count() {
        return Redis::get($this->cacheKey()) ?? 0;
    }
    
    public function record() {
        Redis::incr($this->cacheKey());
        
        return $this;
    }
    
    protected function cacheKey() {
        return app()->environment() == 'testing' ?
            "testing_threads.{$this->thread->id}.visits" : "threads.{$this->thread->id}.visits";
    }
}