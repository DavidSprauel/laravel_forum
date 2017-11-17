<?php


namespace Forum\Models\DataAccess\Read;


use Forum\Models\Entities\Eloquent\Reply as ReplyModel;

class Reply extends BaseReader {
    
    public function __construct() {
        $this->model = ReplyModel::class;
    }
    
    
}