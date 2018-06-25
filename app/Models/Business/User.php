<?php


namespace Forum\Models\Business;


use Forum\Models\Entities\Eloquent\User as UserModel;

class User  extends BaseBusiness {
    
    public function __construct() {
        $this->read = new \Forum\Models\DataAccess\Read\User();
        $this->write = new \Forum\Models\DataAccess\Write\User();
    }
    
    public function getByName($name, $first = false, $nb = null) {
        return $this->read->getByName($name, $first, $nb);
    }
    
    public function uploadAvatar($request) {
        $data = [
            'avatar_path' => $request->file('avatar')->store('avatars', 'public')
        ];
        
        return $this->write->uploadAvatar($data);
    }
    
    public function getByFirst($where) {
        return $this->read->getBy($where, true);
    }
    
    public function confirm(UserModel $user) {
        return $this->write->update($user, [
            'confirmed' => true
        ]);
    }
    
}