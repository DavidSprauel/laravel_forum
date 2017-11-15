<?php


namespace Forum\Models\Business;


abstract class BaseBusiness {
    
    protected $read;
    protected $write;
    
    public function latest() {
        return $this->read->latest();
    }
    
    public function all() {
        return $this->read->all();
    }
    
}