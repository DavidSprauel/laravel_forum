<?php


namespace Forum\Models\DataAccess\Read;


use Forum\Models\Entities\Eloquent\Reply as ReplyModel;
use Forum\Models\Entities\Eloquent\Thread;

class Reply extends BaseReader {
    
    public function __construct() {
        $this->model = ReplyModel::class;
    }
    
    public function getRepliesPaginated(Thread $thread, $limit) {
        return $thread->replies()->paginate($limit);
    }
    
    
}