<?php


namespace Forum\Models\Business;


use Forum\Events\ThreadReceivedNewReply;
use Forum\Models\DataAccess\Read\Thread as ThreadRead;
use Forum\Models\DataAccess\Write\Thread as ThreadWrite;
use Forum\Models\Entities\Eloquent\Channel;
use Forum\Models\Entities\Eloquent\Thread as ThreadModel;

class Thread extends BaseBusiness {
    
    public function __construct() {
        $this->read = new ThreadRead();
        $this->write = new ThreadWrite();
    }
    
    public function addReply(ThreadModel $thread, array $request) {
        $reply = $this->write->addReply($thread, $request);
        
        return $reply;
    }
    
    public function create($request) {
        return $this->write->create([
            'user_id' => auth()->id(),
            'channel_id' => $request['channel_id'],
            'title' => $request['title'],
            'body' => $request['body'],
        ]);
    }
    
    public function latestWithFilter(Channel $channel = null, $filters) {
        return $this->read->latestWithFilter($channel, $filters);
    }
    
    public function deleteOne(ThreadModel $thread) {
        $this->write->deleteOne($thread);
    
        if(request()->wantsJson()) {
            return response([], 204);
        }
        
        return redirect('/threads');
    }
    
    public function lock(ThreadModel $thread) {
        $thread->update(['locked' => true]);
    }
    
    public function unlock(ThreadModel $thread) {
        $thread->update(['locked' => false]);
    }
    
}