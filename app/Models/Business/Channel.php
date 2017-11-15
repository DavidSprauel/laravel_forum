<?php


namespace Forum\Models\Business;


use Forum\Models\Entities\Eloquent\Thread;

class Channel extends BaseBusiness {
    
    public function __construct() {
        $this->read = new \Forum\Models\DataAcces\Read\Channel();
        $this->write = new \Forum\Models\DataAcces\Write\Channel();
    }
    
}