<?php


namespace Forum\Library\Inspections;


class Spam {
    
    protected $inspections = [
        InvalidKeywords::class,
        KeyHeldDown::class
    ];
    
    public function detect($body) {
        foreach($this->inspections as $inspection) {
            app($inspection)->detect($body);
        }
        
        return false;
    }
}