<?php
namespace Tests\Feature;


use Forum\Models\Entities\Eloquent\Thread;
use Forum\Models\Entities\Eloquent\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class LockThreadsTest extends TestCase {
    
    use DatabaseMigrations;
    
    /** @test */
    public function non_administrators_may_not_lock_threads() {
        $this->withExceptionHandling();
        $this->signIn();
        
        $thread = create(Thread::class, ['user_id' => auth()->id()]);
        $this->post(route('locked-threads.store', $thread))->assertStatus(403);
        $this->assertFalse($thread->fresh()->locked);
    }
    
    /** @test */
    public function administrator_can_lock_threads() {
        $this->signIn(factory(User::class)->states('admin')->create());
    
        $thread = create(Thread::class, ['user_id' => auth()->id()]);
        $this->post(route('locked-threads.store', $thread))->assertStatus(200);
        
        $this->assertTrue($thread->fresh()->locked, 'Failed asserting that this thread is locked');
    }
    
    /** @test */
    public function administrator_can_unlock_threads() {
        $this->signIn(factory(User::class)->states('admin')->create());
        
        $thread = create(Thread::class, ['user_id' => auth()->id(), 'locked' => true]);
        $this->delete(route('locked-threads.destroy', $thread))->assertStatus(200);
        
        $this->assertFalse($thread->fresh()->locked, 'Failed asserting that this thread is unlocked');
    }
    
    /** @test */
    public function once_locked_a_thread_may_not_receive_new_replies() {
        $this->signIn();
        $thread = create(Thread::class, ['locked' => true]);
        
        $this->post($thread->path().'/replies', [
            'body' => 'Foobar',
            'user_id' => auth()->id()
        ])->assertStatus(423);
    }
}