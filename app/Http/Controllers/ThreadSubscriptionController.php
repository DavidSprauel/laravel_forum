<?php

namespace Forum\Http\Controllers;

use Forum\Models\Business\ThreadSubscription;
use Forum\Models\Entities\Eloquent\Thread;
use Illuminate\Http\Request;

class ThreadSubscriptionController extends Controller {
    
    public function __construct() {
        $this->middleware('auth');
        
        $this->subscriptionBusiness = new ThreadSubscription();
    }
    
    public function store($channelId, Thread $thread) {
        return $this->subscriptionBusiness->subscribe($thread);
    }
    
    public function destroy($channelId, Thread $thread) {
        return $this->subscriptionBusiness->unsubscribe($thread);
    }
}
