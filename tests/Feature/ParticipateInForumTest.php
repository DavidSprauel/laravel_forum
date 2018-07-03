<?php

namespace Tests\Feature;

use Forum\Models\Entities\Eloquent\Reply;
use Forum\Models\Entities\Eloquent\Thread;
use Forum\Models\Entities\Eloquent\User;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ParticipateInForumTest extends TestCase {
    
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
            ->post($this->thread->path() . '/replies', $reply->toArray())
            ->assertRedirect('/login');
    }
    
    /** @test */
    public function an_authenticated_user_may_participate_in_forum_threads() {
        $this->signIn();
        
        $reply = make(Reply::class);
        
        $this->post($this->thread->path() . '/replies', $reply->toArray());
        $this->get($this->thread->path());
        $this->assertDatabaseHas('replies', ['body' => $reply->body]);
        $this->assertEquals(1, $this->thread->fresh()->replies_count);
    }
    
    /** @test */
    public function a_reply_needs_a_body() {
        $this->withExceptionHandling()->signIn();
        
        $reply = make(Reply::class, ['body' => null]);
        
        $this->post($this->thread->path() . '/replies', $reply->toArray())
            ->assertSessionHasErrors('body');
    }
    
    /** @test */
    public function unauthorized_user_cannot_delete_replies() {
        $this->withExceptionHandling();
        $reply = create(Reply::class);
        
        $this->delete("/replies/{$reply->id}")
            ->assertRedirect('/login');
        
        $this->signIn()
            ->delete("/replies/{$reply->id}")
            ->assertStatus(403);
    }
    
    /** @test */
    public function authorized_users_can_delete_replies() {
        $this->signIn();
        $reply = create(Reply::class, ['user_id' => auth()->id()]);
        
        $this->delete("/replies/{$reply->id}")->assertStatus(302);
        $this->assertDatabaseMissing('replies', ['id' => $reply->id]);
        $this->assertEquals(0, $reply->thread->fresh()->replies_count);
    }
    
    /** @test */
    public function authorized_users_can_update_replies() {
        $this->signIn();
        $reply = create(Reply::class, ['user_id' => auth()->id()]);
        
        $updatedReply = "You've been changed, fool.";
        
        $this->patch("/replies/{$reply->id}", ['body' => $updatedReply]);
        $this->assertDatabaseHas('replies', [
            'id'   => $reply->id,
            'body' => $updatedReply
        ]);
    }
    
    /** @test */
    public function unauthorized_user_can_not_update_replies() {
        $this->withExceptionHandling();
        $reply = create(Reply::class);
        
        $this->patch("/replies/{$reply->id}")
            ->assertRedirect('/login');
        
        $this->signIn()
            ->patch("/replies/{$reply->id}")
            ->assertStatus(403);
    }
    
    /** @test */
    public function replies_that_contains_spam_will_not_be_created() {
        $this->withExceptionHandling()->signIn();
        
        $reply = make(Reply::class, [
            'body' => 'Yahoo Customer support'
        ]);
        
        $this->json('post', $this->thread->path() . '/replies', $reply->toArray())
            ->assertStatus(422);
    }
    
    /** @test */
    public function users_may_only_reply_once_per_minute() {
        $this->withExceptionHandling()->signIn();
        
        $reply = make(Reply::class);
        
        $this->post($this->thread->path() . '/replies', $reply->toArray())
            ->assertStatus(201);
    
        $this->post($this->thread->path() . '/replies', $reply->toArray())
            ->assertStatus(429);
    }
}
