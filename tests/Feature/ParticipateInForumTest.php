<?php

namespace Tests\Feature;

use Forum\Models\Entities\Eloquent\Reply;
use Forum\Models\Entities\Eloquent\Thread;
use Forum\Models\Entities\Eloquent\User;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ParticipateInForumTest extends TestCase
{
    use DatabaseMigrations;
    
    protected $thread;
    
    public function setUp() {
        parent::setUp();
        $this->thread = create(Thread::class);
    }
    
    /** @test */
    public function unauthenticated_user_may_not_add_replies() {
        
        $reply = create(Reply::class);
        $this->withExceptionHandling()
            ->post($this->thread->path().'/replies', $reply->toArray())
            ->assertRedirect('/login');
    }
    
    /** @test */
    public function an_authenticated_user_may_participate_in_forum_threads() {
        $this->signIn();
        
        $reply = make(Reply::class);
        
        $this->post($this->thread->path().'/replies', $reply->toArray());
        $this->get($this->thread->path())
            ->assertSee($reply->body);
    }
    
    /** @test */
    public function a_reply_needs_a_body() {
        $this->withExceptionHandling()->signIn();
    
        $reply = make(Reply::class, ['body' => null]);
    
        $this->post($this->thread->path().'/replies', $reply->toArray())
            ->assertSessionHasErrors('body');
    }
}
