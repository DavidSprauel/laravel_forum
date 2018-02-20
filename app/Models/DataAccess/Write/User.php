<?php


namespace Forum\Models\DataAccess\Write;


use Forum\Models\Entities\Eloquent\User as UserModel;

class User  extends BaseWriter {
    
    public function __construct() {
        $this->model = UserModel::class;
    }
    
    public function uploadAvatar($data) {
        return auth()->user()->update($data);
    }
    
}