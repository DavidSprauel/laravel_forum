<?php


namespace Forum\Models\Business;


class Activity extends BaseBusiness {
    
    public function __construct() {
        $this->read = new \Forum\Models\DataAccess\Read\Activity();
        $this->write = new \Forum\Models\DataAccess\Write\Activity();
    }
    
    public function create($subject, $data) {
        return $this->write->createOne($subject, (array) $data);
    }
}