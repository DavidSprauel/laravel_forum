<?php


namespace Tests\Feature;


use Forum\Models\Entities\Eloquent\Thread;
use Forum\Models\Entities\Eloquent\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class LockThreadsTest extends TestCase {
    
    use DatabaseMigrations;
    
    /** @test */
    public function an_admnistrator_can_lock_any_thread() {
        $this->signIn();
        $thread = create(Thread::class);
        $thread->lock();
        
        $this->post($thread->path().'/replies', [
            'body' => 'Foobar',
            'user_id' => auth()->id()
        ])->assertStatus(423);
    }
}