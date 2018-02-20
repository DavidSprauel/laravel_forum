<?php
/**
 * Created by PhpStorm.
 * User: David
 * Date: 20/02/2018
 * Time: 16:30
 */

namespace Forum\Models\Traits;


use Illuminate\Support\Facades\Redis;

trait RecordsVisits {
    public function visits() {
        return Redis::get($this->cacheKey()) ?? 0;
    }
    
    public function recordsVisit() {
        Redis::incr($this->cacheKey());
        
        return $this;
    }
    
    public function resetVisits() {
        Redis::del($this->cacheKey());
        
        return $this;
    }
    
    protected function cacheKey() {
        return app()->environment() == 'testing' ? "testing_threads.{$this->id}.visits" :"threads.{$this->id}.visits";
    }
}