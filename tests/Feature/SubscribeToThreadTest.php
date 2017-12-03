<?php

namespace Tests\Feature;

use Forum\Models\Entities\Eloquent\Thread;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SubscribeToThreadTest extends TestCase {
    
    use DatabaseMigrations;
    
    protected $thread;
    
    public function setUp() {
        parent::setUp();
        $this->thread = create(Thread::class);
    }
    
    /** @test */
    public function a_user_can_subscribe_to_threads() {
        $this->signIn();
        $this->post($this->thread->path().'/subscriptions');
        
        $this->assertCount(1, $this->thread->fresh()->subscriptions);
    
    }
    
    /** @test */
    public function a_user_can_unsubscribe_from_threads() {
        $this->signIn();
        $this->thread->subscribe();
        $this->delete($this->thread->path().'/subscriptions');
    
        $this->assertCount(0, $this->thread->subscriptions);
    }
}
