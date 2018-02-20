<?php


namespace Tests\Feature;


use Forum\Library\Trending;
use Forum\Models\Entities\Eloquent\Thread;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class TrendingThreadTest  extends TestCase {
    
    use DatabaseMigrations;
    
    protected $trending;
    
    public function setUp() {
        parent::setUp();
        $this->trending = new Trending();
        $this->trending->reset();
    }
    
    /** @test */
    public function it_increments_a_thread_score_each_time_it_is_read() {
        $this->assertEmpty($this->trending->get());
        
        $thread = create(Thread::class);
        $this->call('GET', $thread->path());
        
        $this->assertCount(1, $trending = $this->trending->get());
        $this->assertEquals($thread->title, $trending[0]->title);
    }
}