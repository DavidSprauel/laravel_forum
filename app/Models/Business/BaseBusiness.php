<?php


namespace Forum\Models\Business;


abstract class BaseBusiness {
    
    protected $read;
    protected $write;
    
    public function latest() {
        return $this->read->latest();
    }
    
    public function all() {
        return $this->read->all();
    }
    
    public function delete($entity) {
        return $this->write->delete($entity);
    }
    
    public function getBy($where, $first = false, $nb = null) {
        return $this->read->getBy($where, $first, $nb);
    }
    
    public function getByFirst($where) {
        return $this->read->getBy($where, true);
    }
    
}