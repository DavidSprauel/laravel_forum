<?php

namespace Tests\Feature;

use Forum\Models\Entities\Eloquent\Thread;
use Forum\Models\Entities\Eloquent\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class ProfilesTest extends TestCase {
    
    use DatabaseMigrations;
    
    protected $user;
    
    public function setUp() {
        parent::setUp();
        $this->user = create(User::class);
    }
    
    /** @test */
    public function a_user_has_a_profile() {
        $this->get('/profiles/'. $this->user->name)
            ->assertSee($this->user->name);
    }
    
    /** @test */
    public function profiles_display_all_threads_created_by_associated_user() {
        $thread = create(Thread::class, ['user_id' => $this->user->id]);
        
        $this->get('/profiles/'. $this->user->name)
            ->assertSee($thread->title)
            ->assertSee($thread->body);
    }
    
}
