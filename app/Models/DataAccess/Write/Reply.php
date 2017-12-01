<?php


namespace Forum\Models\DataAccess\Write;


use Forum\Models\Entities\Eloquent\Reply as ReplyModel;

class Reply extends BaseWriter {
    
    public function __construct() {
        $this->model = ReplyModel::class;
    }
    
    public function update(ReplyModel $reply, array $data) {
        $reply->update($data);
        return $reply;
    }
}