<?php


namespace Forum\Models\DataAccess\Read;


abstract class BaseReader {
    
    protected $model;
    
    public function latest() {
        return $this->model::latest()->get();
    }
    
    public function all() {
        return $this->model::all();
    }
    
}