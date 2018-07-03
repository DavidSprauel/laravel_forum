<?php

namespace Forum\Http\Controllers\Auth;

use Forum\Models\Business\User;
use Forum\Http\Controllers\Controller;

class RegisterConfirmationController extends Controller {
    
    protected $userBusiness;
    
    public function __construct() {
        $this->userBusiness = new User();
    }
    
    public function index() {
        $user = $this->userBusiness->getByFirst(['confirmation_token' => request('token')]);
        
        if (!$user) {
            return redirect()->route('threads.index')
                ->with('flash', 'Unknown token.');
        }
        
        $this->userBusiness->confirm($user);
        
        return redirect()->route('threads.index')
            ->with('flash', 'Your account is now confirmed! You may post to the forum.');
    }
}

