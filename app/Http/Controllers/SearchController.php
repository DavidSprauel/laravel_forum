<?php

namespace Forum\Http\Controllers;


use Forum\Library\Trending;
use Forum\Models\Business\Thread;

class SearchController extends Controller
{

    public function __construct()
    {
        $this->threads = new Thread();
    }

    public function show(Trending $trending)
    {
        if (request()->expectsJson()) {
            return $this->threads->search(request('q'));
        }

        return view('threads.search', [
            'trending' => $trending->get()
        ]);
    }
}
