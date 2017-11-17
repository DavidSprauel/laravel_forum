<?php

namespace Forum\Http\Controllers;

use Forum\Models\Business\User;
use Forum\Models\Entities\Eloquent\User as UserModel;
use Illuminate\Http\Request;

class ProfilesController extends Controller {
    
    protected $userBusiness;
    
    public function __construct() {
        $this->userBusiness = new User();
    }
    
    public function show(UserModel $user) {
        return view('profiles.show', [
            'profileUser' => $user
        ]);
    }
}
