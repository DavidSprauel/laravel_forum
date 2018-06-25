<?php

namespace Tests\Feature;

use Forum\Models\Entities\Eloquent\Activity;
use Forum\Models\Entities\Eloquent\Channel;
use Forum\Models\Entities\Eloquent\Reply;
use Forum\Models\Entities\Eloquent\Thread;
use Forum\Models\Entities\Eloquent\User;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class CreateThreadsTest extends TestCase {
    
    use DatabaseMigrations;
    
    /** @test */
    public function guests_may_not_create_threads() {
        $this->withExceptionHandling();
        
        $this->get(route('threads.create'))
            ->assertRedirect(route('login'));
        
        $this->post(route('threads.store'))
            ->assertRedirect(route('login'));
    }
    
    /** @test */
    public function new_users_must_first_confirm_their_email_address_before_creating_threads() {
        $user = factory(User::class)->states('unconfirmed')->create();
        $this->signIn($user);
        $thread = make(Thread::class);
        
        $this->post(route('threads.store'), $thread->toArray())
            ->assertRedirect(route('threads.index'))
            ->assertSessionHas('flash');
    }
    
    /** @test */
    public function an_user_can_create_new_forum_threads() {
        $this->signIn();
        
        $thread = make(Thread::class);
        $response = $this->post(route('threads.store'), $thread->toArray());
        
        $this->get($response->headers->get('Location'))
            ->assertSee($thread->title)
            ->assertSee($thread->body);
    }
    
    /** @test */
    public function a_thread_requires_a_title() {
        $this->publishThread(['title' => null])
            ->assertSessionHasErrors('title');
    }
    
    /** @test */
    public function a_thread_requires_a_body() {
        $this->publishThread(['body' => null])
            ->assertSessionHasErrors('body');
    }
    
    /** @test */
    public function a_thread_requires_a_valid_channel() {
        factory(Channel::class, 2)->create();
        
        $this->publishThread(['channel_id' => null])
            ->assertSessionHasErrors('channel_id');
        
        $this->publishThread(['channel_id' => 999])
            ->assertSessionHasErrors('channel_id');
    }
    
    /** @test */
    public function a_thread_requires_an_unique_slug() {
        $this->signIn();
        $thread = create(Thread::class, ['title' => 'Foo Title', 'slug' => 'foo-title']);
        
        $this->assertEquals($thread->fresh()->slug, 'foo-title');
        
        $this->post(route('threads.store'), $thread->toArray());
        
        $this->assertTrue(Thread::whereSlug('foo-title-2')->exists());
    
        $this->post(route('threads.store'), $thread->toArray());
    
        $this->assertTrue(Thread::whereSlug('foo-title-3')->exists());
    }
    
    public function publishThread($overrides = []) {
        $this->withExceptionHandling()->signIn();
        $thread = make(Thread::class, $overrides);
        
        return $this->post(route('threads.store'), $thread->toArray());
    }
    
    /** @test */
    public function unauthorized_users_may_not_delete_threads() {
        $this->withExceptionHandling();
        $thread = create(Thread::class);
        
        $this->delete($thread->path())
            ->assertRedirect('/login');
        
        $this->signIn();
        $this->delete($thread->path())
            ->assertStatus(403);
    }
    
    /** @test */
    public function authorized_users_can_delete_threads() {
        $this->signIn();
        $thread = create(Thread::class, ['user_id' => auth()->id()]);
        $reply = create(Reply::class, ['thread_id' => $thread->id]);
        
        $response = $this->json('DELETE', $thread->path());
        $response->assertStatus(204);
        
        $this->assertDatabaseMissing('threads', ['id' => $thread->id]);
        $this->assertDatabaseMissing('replies', ['id' => $reply->id]);
        
        $this->assertDatabaseMissing('activities', [
            'subject_id'   => $thread->id,
            'subject_type' => get_class($thread),
        ]);
        
        $this->assertDatabaseMissing('activities', [
            'subject_id'   => $reply->id,
            'subject_type' => get_class($reply),
        ]);
    }
}
