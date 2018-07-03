<?php


namespace Forum\Library\Inspections;


class KeyHeldDown implements SpamInspection {
    
    public function detect($body) {
        if(preg_match('/(.)\\1{4,}/', $body)) {
            throw new \Exception('Your reply contains spam.');
        }
    }
}