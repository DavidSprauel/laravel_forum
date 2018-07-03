<?php

namespace Forum\Http\Controllers\Api;

use Forum\Http\Controllers\Controller;
use Forum\Models\Business\User;

class UsersController extends Controller {
    
    public function __construct() {
        $this->userBusiness = new User();
    }
    
    public function index() {
        $search = request('name');
        return $this->userBusiness->getByName($search, false, 5);
    }
}
