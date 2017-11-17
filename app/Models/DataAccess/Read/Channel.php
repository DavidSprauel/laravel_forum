<?php


namespace Forum\Models\DataAccess\Read;


class Channel extends BaseReader {
    
    public function __construct() {
        $this->model = \Forum\Models\Entities\Eloquent\Channel::class;
    }
    
}