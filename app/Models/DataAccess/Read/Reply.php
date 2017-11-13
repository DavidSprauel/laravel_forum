<?php


namespace Forum\Models\DataAcces\Read;


use Forum\Models\Entities\Eloquent\Reply as ReplyModel;

class Reply extends BaseReader {
    
    public function __construct() {
        $this->model = ReplyModel::class;
    }
    
    
}