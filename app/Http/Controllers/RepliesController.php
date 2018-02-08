<?php

namespace Forum\Http\Controllers;

use Carbon\Carbon;
use Forum\Http\Forms\CreatePostForm;
use Forum\Models\Business\Reply;
use Forum\Models\Business\Thread as ThreadBusiness;
use Forum\Models\Entities\Eloquent\Reply as ReplyModel;
use Forum\Models\Entities\Eloquent\Thread;
use Forum\Rules\SpamFree;
use Gate;

class RepliesController extends Controller {
    
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
    
    public function store($channel, Thread $thread, CreatePostForm $form) {
        return $form->persist($thread);
    }
    
    public function update(ReplyModel $reply) {
        $this->authorize('update', $reply);
        
        try {
            request()->validate([
                'body' => ['required', new SpamFree]
            ]);
            $reply = $this->replyBusiness->update($reply, request()->all());
        } catch (\Exception $e) {
            return response('Sorry, your reply could not be saved at this time.', 422);
        }
        
        return $reply;
    }
    
    public function destroy(ReplyModel $reply) {
        $this->authorize('update', $reply);
        
        $this->replyBusiness->delete($reply);
        
        if (request()->expectsJson()) {
            return response(['status' => 'Reply deleted']);
        }
        
        return back();
    }
}
