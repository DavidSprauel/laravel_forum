<?php

namespace Tests\Feature;

use Forum\Models\Entities\Eloquent\Channel;
use Forum\Models\Entities\Eloquent\Reply;
use Forum\Models\Entities\Eloquent\Thread;
use Forum\Models\Entities\Eloquent\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ReadThreadsTest extends TestCase {
    
    use DatabaseMigrations;
    
    protected $thread;
    
    public function setUp() {
        parent::setUp();
        $this->thread = create(Thread::class);
    }
    
    /** @test */
    public function a_user_can_view_all_threads() {
        $this->get('/threads')
            ->assertSee($this->thread->title);
    }
    
    /** @test */
    public function a_user_can_view_one_threads() {
        $this->get($this->thread->path())
            ->assertSee($this->thread->title);
    }
    
    /** @test */
    public function a_user_can_read_replies_that_are_associated_with_a_thread() {
        $reply = create(Reply::class, ['thread_id' => $this->thread->id]);
        $this->get($this->thread->path())
            ->assertSee($reply->body);
    }
    
    /** @test */
    public function a_user_can_filter_threads_according_to_a_channel() {
        $channel = create(Channel::class);
        $threadInChannel = create(Thread::class, ['channel_id' => $channel->id]);
        $threadNotInChannel = create(Thread::class);
        
        $this->get('/threads/'.$channel->slug)
            ->assertSee($threadInChannel->title)
            ->assertDontSee($threadNotInChannel->title);
    }
    
    /** @test */
    public function a_user_can_filter_threads_by_any_username() {
        $this->signIn(create(User::class, ['name' => 'JohnDoe']));
        
        $threadByJohn = create(Thread::class, ['user_id' => auth()->id()]);
        $threaNotByJohn = $this->thread;
        
        $this->get('/threads?by=JohnDoe')
            ->assertSee($threadByJohn->title)
            ->assertDontSee($threaNotByJohn->title);
    }
    
    /** @test */
    public function a_usr_can_filter_a_thread_by_popularity() {
        $threadWithTwoReplies = create(Thread::class);
        create(Reply::class, ['thread_id' => $threadWithTwoReplies->id ], 2);
    
        $threadWithThreeReplies = create(Thread::class);
        create(Reply::class, ['thread_id' => $threadWithThreeReplies->id ], 3);
        
        $threadWithNoReplies = $this->thread;
        
        $response = $this->getJson('threads?popular=1')->json();
        $this->assertEquals([3,2,0], array_column($response, 'replies_count'));
    }
}
