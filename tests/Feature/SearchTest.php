<?php

namespace Tests\Feature;

use Forum\Models\Entities\Eloquent\Thread;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SearchTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_user_can_search_threads() {
        config(['scout.driver' => 'algolia']);
        $search = 'foobar';

        create(Thread::class, [], 2);
        create(Thread::class, ['body' => "A thread with the {$search} term"], 2);

        do {
            sleep(.25);

            $results = $this->getJson("/threads/search?q={$search}")->json()['data'];
        } while(empty($results));

        $this->assertCount(2, $results);

        Thread::latest()->take(4)->unsearchable();
    }
}
