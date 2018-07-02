<?php

namespace Forum\Http\Controllers;

use Forum\Models\Business\Reply as ReplyBusiness;
use Forum\Models\Entities\Eloquent\Reply;
use Illuminate\Http\Request;

class BestRepliesController extends Controller {
    
    public function __construct() {
        $this->replyBusiness = new ReplyBusiness();
    }
    
    public function store(Reply $reply) {
        $this->authorize('update', $reply->thread);
        
        $this->replyBusiness->setBestReply($reply);
    }
    
}
