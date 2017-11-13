<?php

namespace Tests\Unit;

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
}
