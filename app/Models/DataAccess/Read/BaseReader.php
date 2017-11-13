<?php


namespace Forum\Models\DataAcces\Read;


abstract class BaseReader {
    
    protected $model;
    
    public function latest() {
        return $this->model::latest()->get();
    }
    
}