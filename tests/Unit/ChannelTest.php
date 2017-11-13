<?php

namespace Tests\Feature;

use Forum\Models\Entities\Eloquent\Channel;
use Forum\Models\Entities\Eloquent\Thread;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ChannelTest extends TestCase {
    
    use DatabaseMigrations;
    
    /** @test */
    public function a_channel_consists_of_threads() {
        $channel = create(Channel::class);
        $thread = create(Thread::class, ['channel_id' => $channel->id]);
        
        $this->assertTrue($channel->threads->contains($thread));
    }
}
