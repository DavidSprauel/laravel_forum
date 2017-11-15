<?php


namespace Forum\Models\Business;


class User  extends BaseBusiness {
    
    public function __construct() {
        $this->read = new \Forum\Models\DataAcces\Read\User();
        $this->write = new \Forum\Models\DataAcces\Write\User();
    }
    
    public function getBy(array $where) {
        return $this->read->getBy($where);
    }
    
}