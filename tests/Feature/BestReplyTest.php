<?php


namespace Tests\Feature;


use DB;
use Forum\Models\Entities\Eloquent\Reply;
use Forum\Models\Entities\Eloquent\Thread;
use Forum\Models\Entities\Eloquent\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class BestReplyTest extends TestCase {
    
    use DatabaseMigrations;
    
    /** @test */
    public function a_thread_creator_may_mark_a_reply_as_the_best_reply() {
        $this->signIn();
        
        $thread = create(Thread::class, ['user_id' => auth()->id()]);
        $replies = create(Reply::class, ['thread_id' => $thread->id], 2);
        $this->assertFalse($replies[1]->fresh()->isBest());
        
        $this->postJson(route('best-replies.store', [$replies[1]->id]));
        $this->assertTrue($replies[1]->fresh()->isBest());
    }
    
    /** @test */
    public function only_thread_creator_may_mark_a_reply_as_best() {
        $this->withExceptionHandling();
        
        $this->signIn();
        $thread = create(Thread::class, ['user_id' => auth()->id()]);
        $replies = create(Reply::class, ['thread_id' => $thread->id], 2);
        
        $this->signIn(create(User::class));
        $this->postJson(route('best-replies.store', [$replies[1]->id]))->assertStatus(403);
        $this->assertFalse($replies[1]->fresh()->isBest());
    }
    
    /** @test */
    public function if_a_best_reply_is_deleted_then_the_thread_is_properly_updated_to_reflect_that() {
        $this->signIn();
        $reply = create(Reply::class, ['user_id' => auth()->id()]);
        
        $reply->thread->update(['best_reply_id' => $reply->id]);
        $this->deleteJson(route('replies.destroy', $reply));
        
        $this->assertNull($reply->thread->fresh()->best_reply_id);
        
    }
}