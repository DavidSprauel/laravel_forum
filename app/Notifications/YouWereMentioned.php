<?php

namespace Forum\Notifications;

use Forum\Models\Entities\Eloquent\Reply;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class YouWereMentioned extends Notification {
    
    use Queueable;
    
    protected $reply;
    
    public function __construct(Reply $reply) {
        $this->reply = $reply;
    }
    
    public function via($notifiable) {
        return ['database'];
    }
    
    public function toMail($notifiable) {
        return (new MailMessage)
            ->line('The introduction to the notification.')
            ->action('Notification Action', url('/'))
            ->line('Thank you for using our application!');
    }
    
    public function toArray($notifiable) {
        return [
            'message' => "{$this->reply->owner->name} mentioned you in {$this->reply->thread->title}",
            'link' => $this->reply->path()
        ];
    }
    
}
