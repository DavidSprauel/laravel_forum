<?php

namespace Tests\Unit;

use Carbon\Carbon;
use Forum\Models\Business\Thread as ThreadBusiness;
use Forum\Models\Entities\Eloquent\Channel;
use Forum\Models\Entities\Eloquent\Thread;
use Forum\Models\Entities\Eloquent\User;
use Forum\Notifications\ThreadWasUpdated;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Notification;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ThreadTest extends TestCase {
    use DatabaseMigrations;
    
    protected $thread;
    
    public function setUp() {
        parent::setUp();
        $this->thread = create(Thread::class);
    }
    
    /** @test */
    public function a_thread_can_make_a_string_path() {
        $this->assertEquals(
            "/threads/{$this->thread->channel->slug}/{$this->thread->id}",
            $this->thread->path()
        );
    }
    
    /** @test */
    public function a_thread_has_replies() {
        $this->assertInstanceOf(Collection::class, $this->thread->replies);
    }
    
    /** @test */
    public function a_thread_has_a_creator() {
        $this->assertInstanceOf(User::class, $this->thread->creator);
    }
    
    /** @test */
    public function a_thread_can_add_a_reply() {
        $threadBusiness = new ThreadBusiness();
        $threadBusiness->addReply($this->thread, [
            'body' => 'Foobar',
            'user_id' => 1
        ]);
        
        $this->assertCount(1, $this->thread->replies);
    }
    
    /** @test */
    public function a_thread_notifies_all_registered_subscribers_when_a_reply_is_added() {
        Notification::fake();
        
        $this->signIn()->thread->subscribe();
    
        $threadBusiness = new ThreadBusiness();
        $threadBusiness->addReply($this->thread, [
            'body' => 'Foobar',
            'user_id' => 999
        ]);
        
        
        Notification::assertSentTo(auth()->user(), ThreadWasUpdated::class);
    }
    
    /** @test */
    public function a_thread_belongs_to_a_channel() {
        $this->assertInstanceOf( Channel::class, $this->thread->channel);
    }
    
    /** @test */
    public function a_thread_can_be_subscribed_to() {
        $this->thread->subscribe($userId = 1);
        
        $this->assertEquals(
            1,
            $this->thread->subscriptions()->where('user_id', $userId)->count()
        );
    }
    
    /** @test */
    public function a_thread_can_be_unsubscribe_from() {
        $this->thread->subscribe($userId = 1);
        $this->thread->unsubscribe($userId);
    
        $this->assertCount(0, $this->thread->subscriptions);
    }
    
    /** @test */
    public function it_knows_if_authenticated_user_is_subscribed_to_it() {
        $this->signIn();
        $this->assertFalse($this->thread->isSubscribedTo);
        $this->thread->subscribe();
        $this->assertTrue($this->thread->isSubscribedTo);
    }
    
    /** @test */
    public function a_thread_can_check_if_the_authenticated_user_has_read_all_replies() {
        $this->signIn();
        tap(auth()->user(), function($user) {
            $this->assertTrue($this->thread->hasUpdatesFor($user));
    
            $user->read($this->thread);
    
            $this->assertFalse($this->thread->hasUpdatesFor($user));
        });
    }
}
