<?php


namespace Forum\Models\DataAccess\Read;


class ThreadSubscription extends BaseReader {
    
    public function __construct() {
        $this->model = \Forum\Models\Entities\Eloquent\ThreadSubscription::class;
    }
}