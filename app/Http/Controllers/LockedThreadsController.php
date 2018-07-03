<?php

namespace Forum\Http\Controllers;

use Forum\Models\Business\Thread;
use Forum\Models\Entities\Eloquent\Thread as ThreadModel;
use Illuminate\Http\Request;

class LockedThreadsController extends Controller
{
    protected $threadBusiness;
    
    public function __construct() {
        $this->threadBusiness = new Thread();
    }
    
    public function store(ThreadModel $thread) {
        $this->threadBusiness->lock($thread);
    }
    
    public function destroy(ThreadModel $thread) {
        $this->threadBusiness->unlock($thread);
    }
}
