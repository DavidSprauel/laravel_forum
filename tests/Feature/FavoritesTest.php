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
    
    /** @test */
    public function an_authenticate_user_can_unfavorite_a_reply() {
        $this->signIn();
        
        $this->reply->favorite();
    
        $this->delete('replies/'.$this->reply->id.'/favorites');
        $this->assertCount(0, $this->reply->favorites);
    }
    
    /** @test */
    public function a_user_may_only_favorite_a_reply_once() {
        $this->signIn();
    
        $this->post('replies/'.$this->reply->id.'/favorites');
        $this->post('replies/'.$this->reply->id.'/favorites');
        $this->assertCount(1, $this->reply->favorites);
    }
}
