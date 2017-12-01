<?php


namespace Forum\Models\Business;


use Forum\Models\Entities\Eloquent\User;

class Activity extends BaseBusiness {
    
    public function __construct() {
        $this->read = new \Forum\Models\DataAccess\Read\Activity();
        $this->write = new \Forum\Models\DataAccess\Write\Activity();
    }
    
    public function create($subject, $data) {
        return $this->write->createOne($subject, (array) $data);
    }
    
    public function getFeed(User $user) {
        return $this->read->getFeed($user);
    }
}