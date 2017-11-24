<?php

namespace Forum\Http\Controllers;

use Forum\Filters\ThreadFilters;
use Forum\Models\Business\Thread as ThreadBusiness;
use Forum\Models\Entities\Eloquent\Channel;
use Forum\Models\Entities\Eloquent\Thread;
use Illuminate\Http\Request;

class ThreadsController extends Controller {
    
    protected $threadBusiness;
    protected $filters = ['by', 'popularity'];
    
    public function __construct() {
        $this->middleware('auth')->except(['index', 'show']);
        $this->threadBusiness = new ThreadBusiness();
    }
    
    public function index(Channel $channel = null, ThreadFilters $filters) {
        $threads = $this->getThreads($channel, $filters);
        
        if(request()->wantsJson()) {
            return $threads;
        }
        
        return view('threads.index', compact('threads'));
    }
    
    public function create() {
        return view('threads.create');
    }
    
    public function store(Request $request) {
        $this->validate($request, [
            'title' => 'required',
            'body' => 'required',
            'channel_id' => 'required|exists:channels,id',
        ]);
        
        $thread = $this->threadBusiness->create([
            'user_id' => auth()->id(),
            'channel_id' => request('channel_id'),
            'title' => request('title'),
            'body' => request('body'),
        ]);
        
        return redirect($thread->path());
    }
    
    public function show($channelId, Thread $thread) {
        return view('threads.show', [
            'thread' => $thread,
            'replies' => $thread->replies()->paginate(25)
        ]);
    }
    
    public function edit(Thread $thread) {
        //
    }
    
    public function update(Request $request, Thread $thread) {
        //
    }
    
    public function destroy(Channel $channel, Thread $thread) {
        $this->authorize('update', $thread);
        
        $return = $this->threadBusiness->delete($thread);
        
        return $return;
    }
    
    private function getThreads(Channel $channel = null, ThreadFilters $filters) {
        $threads = $this->threadBusiness->latestWithFilter($channel, $filters);
        
        return $threads;
    }
}
