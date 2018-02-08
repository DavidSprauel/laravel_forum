<?php

namespace Forum\Http\Controllers;

use Carbon\Carbon;
use Forum\Filters\ThreadFilters;
use Forum\Library\Inspections\Spam;
use Forum\Models\Business\Thread as ThreadBusiness;
use Forum\Models\Entities\Eloquent\Channel;
use Forum\Models\Entities\Eloquent\Thread;
use Forum\Rules\SpamFree;
use Illuminate\Http\Request;

class ThreadsController extends Controller {
    
    protected $threadBusiness;
    protected $filters = ['by', 'popularity', 'unanswered'];
    
    public function __construct() {
        $this->middleware('auth')->except(['index', 'show']);
        $this->threadBusiness = new ThreadBusiness();
    }
    
    public function index(Channel $channel = null, ThreadFilters $filters) {
        $threads = $this->getThreads($channel, $filters);
        
        if (request()->wantsJson()) {
            return $threads;
        }
        
        return view('threads.index', compact('threads'));
    }
    
    public function create() {
        return view('threads.create');
    }
    
    public function store() {
        request()->validate([
            'title'      => ['required', new SpamFree],
            'body'       => ['required', new SpamFree],
            'channel_id' => 'required|exists:channels,id',
        ]);
        
        $thread = $this->threadBusiness->create(request()->all());
        
        return redirect($thread->path())
            ->with('flash', 'Your thread has been published');
    }
    
    public function show($channelId, Thread $thread) {
        if (auth()->check()) {
            auth()->user()->read($thread);
        }
        
        return view('threads.show', compact('thread'));
    }
    
    public function edit(Thread $thread) {
        //
    }
    
    public function update(Request $request, Thread $thread) {
        //
    }
    
    public function destroy(Channel $channel, Thread $thread) {
        $this->authorize('update', $thread);
        
        $return = $this->threadBusiness->deleteOne($thread);
        
        return $return;
    }
    
    private function getThreads(Channel $channel = null, ThreadFilters $filters) {
        $threads = $this->threadBusiness->latestWithFilter($channel, $filters);
        
        return $threads;
    }
}
