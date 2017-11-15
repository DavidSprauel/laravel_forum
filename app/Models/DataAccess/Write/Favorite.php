<?php


namespace Forum\Models\DataAcces\Write;


class Favorite extends BaseWriter {
    
    public function __construct() {
        $this->model = \Forum\Models\Entities\Eloquent\Favorite::class;
    }
    
    public function insert($data) {
        return $this->model::insert($data);
    }
}