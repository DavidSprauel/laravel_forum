<?php


namespace Forum\Models\DataAccess\Read;


class User extends BaseReader {
    
    public function __construct() {
        $this->model = \Forum\Models\Entities\Eloquent\User::class;
    }
    
    public function getBy($where) {
        return $this->model::where($where)->firstOrFail();
    }
}