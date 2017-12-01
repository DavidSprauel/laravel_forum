<?php


namespace Forum\Models\DataAccess\Write;


abstract class BaseWriter {
    
    protected $model;
    
    public function create($fields) {
        return $this->model::create($fields);
    }
    
    public function delete($entity) {
        return $entity->delete();
    }
    
}