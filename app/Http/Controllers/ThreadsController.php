<?php

namespace Forum\Http\Controllers;

use Forum\Models\Business\Thread as ThreadBusiness;
use Forum\Models\Entities\Eloquent\Channel;
use Forum\Models\Entities\Eloquent\Thread;
use Illuminate\Http\Request;

class ThreadsController extends Controller {
    
    protected $threadBusiness;
    
    public function __construct() {
        $this->middleware('auth')->except(['index', 'show']);
        $this->threadBusiness = new ThreadBusiness();
    }
    
    public function index(Channel $channel = null) {
        $threads = $this->threadBusiness->latest($channel);
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
        return view('threads.show', compact('thread'));
    }
    
    public function edit(Thread $thread) {
        //
    }
    
    public function update(Request $request, Thread $thread) {
        //
    }
    
    public function destroy(Thread $thread) {
        //
    }
}
