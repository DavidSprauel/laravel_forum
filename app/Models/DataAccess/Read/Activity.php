<?php


namespace Forum\Models\DataAccess\Read;


use Forum\Models\Entities\Eloquent\User;

class Activity extends BaseReader {
    
    public function __construct() {
        $this->model = \Forum\Models\Entities\Eloquent\Activity::class;
    }
    
    public function getFeed(User $user) {
        return $this->model::feed($user);
    }
}