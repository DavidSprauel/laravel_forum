<?php


namespace Forum\Models\DataAccess\Write;


use Forum\Models\Entities\Eloquent\Thread;
use Illuminate\Database\Eloquent\Model;

abstract class BaseWriter {
    
    protected $model;
    
    public function create($fields) {
        return $this->model::create($fields);
    }
    
    public function delete($entity) {
        return $entity->delete();
    }
    
}