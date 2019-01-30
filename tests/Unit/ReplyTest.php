<?php

namespace Tests\Unit;

use Carbon\Carbon;
use Forum\Models\Entities\Eloquent\Reply;
use Forum\Models\Entities\Eloquent\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ReplyTest extends TestCase {
    
    use DatabaseMigrations;
    
    /** @test */
    public function it_has_an_owner() {
       $reply = create(Reply::class);
       $this->assertInstanceOf(User::class, $reply->owner);
    }
    
    /** @test */
    public function it_knows_if_it_was_published() {
        $reply = create(Reply::class);
        $this->assertTrue($reply->wasJustPublished());
        
        $reply->created_at = Carbon::now()->subMonth();
        $this->assertFalse($reply->wasJustPublished());
    }
    
    /** @test */
    public function it_can_detect_all_the_mentioned_users_in_the_body() {
        $reply = new Reply([
            'body' => '@JaneDoe wants to talk to @JohnDoe'
        ]);
        
        $this->assertEquals(['JaneDoe', 'JohnDoe'], $reply->mentionedUsers());
    }
    
    /** @test */
    public function it_wraps_mentioned_usernames_int_the_body_within_anchor_tags() {
        $reply = new Reply([
            'body' => 'Hello @Jane-Doe.'
        ]);
        
        $this->assertEquals(
            'Hello <a href="/profiles/Jane-Doe">@Jane-Doe</a>.',
            $reply->body
        );
    }
    
    /** @test */
    public function it_knows_if_it_is_the_best_reply() {
        $reply = create(Reply::class);
        $this->assertFalse($reply->isBest());
        
        $reply->thread->update(['best_reply_id' => $reply->id]);
        $this->assertTrue($reply->fresh()->isBest());
    }

    /** @test */
    public function a_reply_body_is_sanitized_automatically() {
        $reply = make(Reply::class, ['body' => '<script>alert("bad")</script><p>This is okay</p>']);

        $this->assertEquals('<p>This is okay</p>', $reply->body);
    }
}
