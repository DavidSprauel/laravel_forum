<?php


namespace Tests\Feature;


use Forum\Models\Entities\Eloquent\Reply;
use Forum\Models\Entities\Eloquent\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class UserTest extends TestCase {
    
    use DatabaseMigrations;
    
    /** @test */
    public function a_user_can_fetch_their_most_recent_reply() {
        $user = create(User::class);
        $reply = create(Reply::class, ['user_id' => $user->id]);
        
        $this->assertEquals($user->lastReply->id, $reply->id);
    }
}