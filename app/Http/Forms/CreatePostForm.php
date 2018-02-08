<?php

namespace Forum\Http\Forms;

use Forum\Exceptions\ThrottleException;
use Forum\Models\Business\Thread;
use Forum\Models\Entities\Eloquent\Reply;
use Forum\Rules\SpamFree;
use Illuminate\Foundation\Http\FormRequest;

class CreatePostForm extends FormRequest {
    
    public function authorize() {
        return \Gate::allows('create', Reply::class);
    }
    
    public function failedAuthorization() {
        throw new ThrottleException('You are posting too frequently. Please take a break. :)');
    }
    
    public function rules() {
        return [
            'body' => ['required', new SpamFree]
        ];
    }
    
    public function persist($thread) {
        return (new Thread())->addReply($thread, [
            'body' => request('body'),
            'user_id' => auth()->id()
        ])->load('owner');
    }
}
