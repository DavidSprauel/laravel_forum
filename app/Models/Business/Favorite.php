<?php


namespace Forum\Models\Business;


use Forum\Models\DataAccess\Read\Favorite as FavoriteRead;
use Forum\Models\DataAccess\Write\Favorite as FavoriteWrite;

class Favorite extends BaseBusiness {
    
    public function __construct() {
        $this->read = new FavoriteRead;
        $this->write = new FavoriteWrite;
    }
    
    public function store($reply) {
        return $this->write->insert($reply);
    }
}