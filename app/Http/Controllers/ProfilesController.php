<?php

namespace Forum\Http\Controllers;

use Forum\Models\Business\Activity;
use Forum\Models\Business\User;
use Forum\Models\Entities\Eloquent\User as UserModel;
use Illuminate\Http\Request;

class ProfilesController extends Controller {
    
    protected $userBusiness;
    protected $activityBusiness;
    
    public function __construct() {
        $this->userBusiness = new User();
        $this->activityBusiness = new Activity();
    }
    
    public function show(UserModel $user) {
        return view('profiles.show', [
            'profileUser' => $user,
            'activities' => $this->activityBusiness->getFeed($user),
        ]);
    }
}
