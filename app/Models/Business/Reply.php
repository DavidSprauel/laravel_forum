<?php


namespace Forum\Models\Business;


use Forum\Models\DataAcces\Read\Reply as ReplyRead;
use Forum\Models\DataAcces\Write\Reply as ReplyWrite;

class Reply extends BaseBusiness {
    
    public function __construct() {
        $this->read = new ReplyRead();
        $this->write = new ReplyWrite();
    }
    
    
}