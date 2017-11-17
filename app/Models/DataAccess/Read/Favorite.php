<?php


namespace Forum\Models\DataAccess\Read;


class Favorite extends BaseReader {
    
    public function __construct() {
        $this->model = \Forum\Models\Entities\Eloquent\Favorite::class;
    }
}