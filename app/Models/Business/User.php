<?php


namespace Forum\Models\Business;


class User  extends BaseBusiness {
    
    public function __construct() {
        $this->read = new \Forum\Models\DataAccess\Read\User();
        $this->write = new \Forum\Models\DataAccess\Write\User();
    }
    
    public function getBy(array $where) {
        return $this->read->getBy($where);
    }
    
}