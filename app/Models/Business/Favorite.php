<?php


namespace Forum\Models\Business;


use Forum\Models\DataAccess\Read\Favorite as FavoriteRead;
use Forum\Models\DataAccess\Write\Favorite as FavoriteWrite;
use Forum\Models\Entities\Eloquent\Reply;

class Favorite extends BaseBusiness {
    
    public function __construct() {
        $this->read = new FavoriteRead;
        $this->write = new FavoriteWrite;
    }
    
    public function store($entity) {
        return $this->write->insert($entity);
    }
    
    public function delete($entity) {
        return $this->write->delete($entity);
    }
}