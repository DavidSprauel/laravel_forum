<?php


namespace Forum\Models\DataAccess\Write;


class Favorite extends BaseWriter {
    
    public function __construct() {
        $this->model = \Forum\Models\Entities\Eloquent\Favorite::class;
    }
    
    public function insert($entity) {
        return $entity->favorite();
    }
    
    public function delete($entity) {
        return $entity->unfavorite();
    }
}