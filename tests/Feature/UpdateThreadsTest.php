<?php

namespace Tests\Feature;

use Forum\Models\Entities\Eloquent\Thread;
use Forum\Models\Entities\Eloquent\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UpdateThreadsTest extends TestCase {
    
    use RefreshDatabase;
    
    protected $thread;
    
    public function setUp() {
        parent::setUp();
        
        $this->withExceptionHandling();
        $this->signIn();
        $this->thread = create(Thread::class, ['user_id' => auth()->id()]);
    }
    
    /** @test */
    public function a_thread_requires_a_title_and_body_to_be_updated() {
        $this->patch($this->thread->path(), [
            'title' => 'Changed',
        ])->assertSessionHasErrors('body');
        
        $this->patch($this->thread->path(), [
            'body' => 'Changed',
        ])->assertSessionHasErrors('title');
    }
    
    /** @test */
    public function unauthorized_users_may_not_update_threads() {
        $thread = create(Thread::class, ['user_id' => create(User::class)]);
        
        $this->patch($thread->path(), [])->assertStatus(403);
    }
    
    /** @test */
    public function a_thread_can_be_updated_by_its_creator() {
        $this->patch($this->thread->path(), [
            'title' => 'Changed',
            'body' => 'Changed body.'
        ]);
        
        tap($this->thread->fresh(), function($thread) {
            $this->assertEquals('Changed', $thread->title);
            $this->assertEquals('Changed body.', $thread->body);
        });
    }
}
