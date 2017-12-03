<?php

namespace Tests\Feature;

use Forum\Models\Entities\Eloquent\Notification;
use Forum\Models\Entities\Eloquent\Reply;
use Forum\Models\Entities\Eloquent\Thread;
use Forum\Models\Entities\Eloquent\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class NotificationTest extends TestCase {
    
    use DatabaseMigrations;
    
    public function setUp() {
        parent::setUp();
    
        $this->signIn();
    }
    
    /** @test */
    function notification_prepared_when_subscribed_thread_recieves_new_reply_not_by_the_current_user() {
        $thread = create(Thread::class)->subscribe();
    
        $this->assertCount(0, auth()->user()->notifications);
    
        $thread->replies()->create([
            'user_id' => auth()->id(),
            'body' => 'some reply over there'
        ]);
    
        $this->assertCount(0, auth()->user()->fresh()->notifications);
        
        create(Reply::class, ['thread_id' => $thread->id]);
    
        $this->assertCount(1, auth()->user()->fresh()->notifications);
    }
    
    /** @test */
    public function a_user_can_fetch_his_unread_notifications() {
        create(Notification::class);
    
        $this->assertCount(
            1,
            $this->getJson("profiles/".auth()->user()->name."/notifications")->json()
        );
    }
    
    /** @test */
    public function a_user_can_mark_a_nofication_as_read() {
        create(Notification::class);
        
        tap(auth()->user(), function($user) {
            $this->assertCount(1, $user->unreadNotifications);
    
            $notifId = $user->unreadNotifications->first()->id;
    
            $this->delete("profiles/{$user->name}/notifications/{$notifId}");
    
            $this->assertCount(0, $user->fresh()->unreadNotifications);
        });
    }
}
