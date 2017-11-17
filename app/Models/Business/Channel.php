<?php


namespace Forum\Models\Business;


use Forum\Models\Entities\Eloquent\Thread;

class Channel extends BaseBusiness {
    
    public function __construct() {
        $this->read = new \Forum\Models\DataAccess\Read\Channel();
        $this->write = new \Forum\Models\DataAccess\Write\Channel();
    }
    
}