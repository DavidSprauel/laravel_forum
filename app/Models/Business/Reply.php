<?php


namespace Forum\Models\Business;


use Forum\Models\DataAccess\Read\Reply as ReplyRead;
use Forum\Models\DataAccess\Write\Reply as ReplyWrite;
use Forum\Models\Entities\Eloquent\Reply as ReplyModel;

class Reply extends BaseBusiness {
    
    public function __construct() {
        $this->read = new ReplyRead();
        $this->write = new ReplyWrite();
    }
    
    public function update(ReplyModel $reply, $data) {
        return $this->write->update($reply, [
            'body' => $data['body']
        ]);
    }
    
    
    
    
}