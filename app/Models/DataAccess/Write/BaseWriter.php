<?php


namespace Forum\Models\DataAcces\Write;


abstract class BaseWriter {
    
    protected $model;
    
    public function create($fields) {
        return $this->model::create($fields);
    }
    
}