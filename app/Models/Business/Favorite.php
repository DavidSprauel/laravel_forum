<?php


namespace Forum\Models\Business;


class Favorite extends BaseBusiness {
    
    public function __construct() {
        $this->read = \Forum\Models\DataAcces\Read\Favorite::class;
        $this->write = \Forum\Models\DataAcces\Write\Favorite::class;
    }
    
    public function store($data) {
        return $this->write->insert($data);
    }
}