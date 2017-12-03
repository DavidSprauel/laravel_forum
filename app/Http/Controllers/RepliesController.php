<?php

namespace Forum\Http\Controllers;

use Forum\Models\Business\Reply;
use Forum\Models\Business\Thread as ThreadBusiness;
use Forum\Models\Entities\Eloquent\Channel;
use Forum\Models\Entities\Eloquent\Reply as ReplyModel;
use Forum\Models\Entities\Eloquent\Thread;
use Illuminate\Http\Request;

class RepliesController extends Controller
{
    protected $replyBusiness;
    protected $threadBusiness;
    protected $limit;
    
    public function __construct() {
        $this->middleware('auth', ['except' => ['index']]);
        
        $this->replyBusiness = new Reply();
        $this->threadBusiness = new ThreadBusiness();
        $this->limit = 10;
    }
    
    public function index($channelId, Thread $thread) {
        return $this->replyBusiness->getRepliesPaginated($thread, $this->limit);
    }
    
    public function store($channel, Thread $thread) {
        $this->validate(request(), [
            'body' => 'required'
        ]);
        
        $reply = $this->threadBusiness->addReply($thread, [
            'body' => request('body'),
            'user_id' => auth()->id()
        ]);
        
        if(request()->expectsJson()) {
            return $reply->load('owner');
        }
        
        return back()->with('flash', 'Your reply has been left.');
    }
    
    public function update(ReplyModel $reply) {
        $this->authorize('update', $reply);
        return $this->replyBusiness->update($reply, request()->all());
    }
    
    public function destroy(ReplyModel $reply) {
        $this->authorize('update', $reply);
        
        $this->replyBusiness->delete($reply);
        
        if(request()->expectsJson()) {
            return response(['status' => 'Reply deleted']);
        }
        
        return back();
    }
}
