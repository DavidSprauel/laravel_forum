<?php

namespace Tests\Feature;

use Forum\Models\Entities\Eloquent\Reply;
use Forum\Models\Entities\Eloquent\Thread;
use Forum\Models\Entities\Eloquent\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MentionUsersTest extends TestCase {
    
    use DatabaseMigrations;
    
    /** @test */
    public function mentionned_users_in_a_reply_are_notified() {
        $john  = create(User::class, ['name' => 'JohnDoe']);
        $this->signIn($john);
    
        $jane  = create(User::class, ['name' => 'JaneDoe']);
        $thread = create(Thread::class);
        $reply = make(Reply::class, [
            'body' => '@JaneDoe look at this. Also @FrankDoe'
        ]);
        
        $this->json('post', $thread->path() . '/replies', $reply->toArray());
        
        $this->assertCount(1, $jane->notifications);
    }
    
    /** @test */
    public function it_can_fetch_all_mentioned_users_starting_with_the_given_character() {
        create(User::class, ['name' => 'JohnDoe']);
        create(User::class, ['name' => 'JohnDoe2']);
        create(User::class, ['name' => 'JaneDoe']);
        
        $results = $this->json('GET', '/api/users', ['name' => 'john']);
        $this->assertCount(2, $results->json());
    }
}
