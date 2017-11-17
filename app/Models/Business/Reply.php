<?php


namespace Forum\Models\Business;


use Forum\Models\DataAccess\Read\Reply as ReplyRead;
use Forum\Models\DataAccess\Write\Reply as ReplyWrite;

class Reply extends BaseBusiness {
    
    public function __construct() {
        $this->read = new ReplyRead();
        $this->write = new ReplyWrite();
    }
    
    
}