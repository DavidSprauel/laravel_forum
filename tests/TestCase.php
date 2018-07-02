<?php

namespace Tests;

use DB;
use Forum\Models\Entities\Eloquent\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase {
    
    use CreatesApplication;
    
    public function setUp() {
        parent::setUp();
        $this->withoutExceptionHandling();
        DB::statement('PRAGMA foreign_keys=on;');
    }
    
    protected function signIn($user = null) {
        $user = $user ? : create(User::class);
        $this->actingAs($user);
        
        return $this;
    }
    
}
