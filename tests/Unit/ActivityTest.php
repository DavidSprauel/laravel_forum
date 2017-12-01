<?php

namespace Tests\Feature;

use Carbon\Carbon;
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
    
    /** @test */
    public function it_fetches_a_feed_for_any_user() {
        $this->signIn();
    
        create(Thread::class, ['user_id' => auth()->id()], 2);
        
        auth()->user()->activity()->first()->update(['created_at' => Carbon::now()->subWeek()]);
        
        $feed = Activity::feed(auth()->user());
        $this->assertTrue($feed->keys()->contains(
            Carbon::now()->format('d-m-Y')
        ));
    
        $this->assertTrue($feed->keys()->contains(
            Carbon::now()->subWeek()->format('d-m-Y')
        ));
    }
}
