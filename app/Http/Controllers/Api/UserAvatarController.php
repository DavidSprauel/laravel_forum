<?php

namespace Forum\Http\Controllers\Api;

use Forum\Models\Business\User;
use Forum\Models\Entities\Eloquent\User as UserModel;
use Illuminate\Http\Request;
use Forum\Http\Controllers\Controller;

class UserAvatarController extends Controller {
    
    protected $userBusiness;
    
    public function __construct() {
        $this->userBusiness = new User();
    }
    
    public function store() {
        request()->validate([
             'avatar' => ['required', 'image']
        ]);
        
        $this->userBusiness->uploadAvatar(request());
        
        return response([], 204);
    }
}
