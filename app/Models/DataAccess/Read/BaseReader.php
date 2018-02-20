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
    
    public function getBy($where, $first = false, $nb = null) {
        if($first) {
            return $this->model::where($where)->first();
        }
        
        if(!is_null($nb)) {
            return $this->model::where($where)->take($nb)->get();
        }
        
        return $this->model::where($where)->get();
    }
    
}