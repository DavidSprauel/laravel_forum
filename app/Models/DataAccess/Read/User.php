<?php


namespace Forum\Models\DataAccess\Read;


class User extends BaseReader {
    
    public function __construct() {
        $this->model = \Forum\Models\Entities\Eloquent\User::class;
    }
    
    public function getByName($name, $first = false, $nb = null) {
        $users = $this->model::where('name', 'LIKE', "$name%");
        
        if($first){
            return $users->pluck('name');
        }
        
        if(!is_null($nb)) {
            return $users->take(5)->pluck('name');
        }
        
        return $users->pluck('name');
    }
}