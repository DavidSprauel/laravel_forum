<?php

namespace Forum\Http\Controllers;

use Forum\Models\Business\Reply;
use Forum\Models\Business\Thread as ThreadBusiness;
use Forum\Models\Entities\Eloquent\Channel;
use Forum\Models\Entities\Eloquent\Thread;
use Illuminate\Http\Request;

class RepliesController extends Controller
{
    protected $replyBusiness;
    protected $threadBusiness;
    
    public function __construct() {
        $this->middleware('auth');
        
        $this->replyBusiness = new Reply();
        $this->threadBusiness = new ThreadBusiness();
    }
    
    public function store($channel, Thread $thread) {
        $this->validate(request(), [
            'body' => 'required'
        ]);
        
        $this->threadBusiness->addReply($thread, [
            'body' => request('body'),
            'user_id' => auth()->id()
        ]);
        
        return back();
    }
}
