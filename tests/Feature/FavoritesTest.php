<?php

namespace Tests\Feature;

use Forum\Models\Entities\Eloquent\Reply;
use Forum\Models\Entities\Eloquent\Thread;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class FavoritesTest extends TestCase {
    
    use DatabaseMigrations;
    
    protected $reply;
    
    public function setUp() {
        parent::setUp();
        $this->reply = create(Reply::class);
    }
    
    /** @test */
    public function guests_can_not_favorite_anything() {
        $this->withExceptionHandling();
        $this->post('replies/'.$this->reply->id.'/favorites')
            ->assertRedirect('/login');
    }
    
    /** @test */
    public function an_authenticate_user_can_favorite_any_reply() {
        $this->signIn();
        
        $this->post('replies/'.$this->reply->id.'/favorites');
        $this->assertCount(1, $this->reply->favorites);
    }
}
