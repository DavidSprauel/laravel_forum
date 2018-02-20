<?php

namespace Forum\Listeners;

use Forum\Events\ThreadReceivedNewReply;
use Forum\Models\Business\User;
use Forum\Notifications\YouWereMentioned;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class NotifyMentionedUsers {
    
    public function handle(ThreadReceivedNewReply $event) {
        $userBusiness = new User();
        $users = $userBusiness->getBy(function ($where) use ($event) {
            $where->whereIn('name', $event->reply->mentionedUsers());
        });
        
        $users->each(function ($user) use ($event) {
            $user->notify(new YouWereMentioned($event->reply));
        });
    }
}
