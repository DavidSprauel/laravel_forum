<?php

namespace Tests\Feature;

use Forum\Models\Entities\Eloquent\Activity;
use Forum\Models\Entities\Eloquent\Channel;
use Forum\Models\Entities\Eloquent\Reply;
use Forum\Models\Entities\Eloquent\Thread;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ActivityTest extends TestCase {
    
    use DatabaseMigrations;
    
    /** @test */
    public function it_records_activity_when_a_thread_is_created() {
        $this->signIn();
        $thread = create(Thread::class);
        
        $this->assertDatabaseHas('activities', [
            'type' => 'created_thread',
            'user_id' => auth()->id(),
            'subject_id' => $thread->id,
            'subject_type' => Thread::class
        ]);
        
        $activity = Activity::first();
        
        $this->assertEquals($activity->subject->id, $thread->id);
    }
    
    /** @test */
    public function it_records_an_activity_when_a_reply_is_created() {
        $this->signIn();
        
        $reply = create(Reply::class);
        $this->assertEquals(2, Activity::count());
    }
}
