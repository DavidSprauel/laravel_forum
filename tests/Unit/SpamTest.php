<?php

namespace Tests\Feature;

use Forum\Library\Inspections\Spam;
use Forum\Models\Entities\Eloquent\Thread;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class SpamTest extends TestCase {
    
    use DatabaseMigrations;
    
    protected $thread;
    
    public function setUp() {
        parent::setUp();
        $this->thread = create(Thread::class);
    }
    
    /** @test */
    public function it_checks_for_invalid_keywords() {
        $spam = new Spam();
        
        $this->assertFalse($spam->detect('Innocent reply here'));
    
        $this->expectException(\Exception::class);
    
        $spam->detect('yahoo customer support');
    }
    
    /** @test */
    public function it_checks_for_any_key_being_held_down() {
        $spam = new Spam();
        
        $this->expectException(\Exception::class);
        
        $spam->detect('Hello world aaaaaa');
    }
    
}
