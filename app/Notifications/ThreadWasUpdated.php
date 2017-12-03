<?php

namespace Forum\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;

class ThreadWasUpdated extends Notification {
    
    use Queueable;
    
    protected $thread;
    protected $reply;
    
    public function __construct($thread, $reply) {
        $this->thread = $thread;
        $this->reply = $reply;
    }
    
    public function via($notifiable) {
        return ['database'];
    }
    
    public function toArray($notifiable) {
        return [
            'message' => "{$this->reply->owner->name} replied to {$this->thread->title}",
            'link' => $this->reply->path()
        ];
    }
}
