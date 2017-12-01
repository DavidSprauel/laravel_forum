<?php


namespace Forum\Models\DataAccess\Write;


use Forum\Models\Entities\Eloquent\Thread as ThreadModel;

class Thread extends BaseWriter {
    
    public function __construct() {
        $this->model = ThreadModel::class;
    }
    
    public function addReply(ThreadModel $thread, array $request) {
        $thread->replies()->create($request);
    }
    
    public function deleteOne(ThreadModel $thread) {
        return $thread->delete();
    }
    
}