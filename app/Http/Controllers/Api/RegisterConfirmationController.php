<?php

namespace Forum\Http\Controllers\Api;

use Forum\Models\Business\User;
use Forum\Http\Controllers\Controller;

class RegisterConfirmationController extends Controller {
    
    protected $userBusiness;
    
    public function __construct() {
        $this->userBusiness = new User();
    }
    
    public function index() {
        try {
            
            $user = $this->userBusiness->getByFirst(['confirmation_token' => request('token')]);
            $this->userBusiness->confirm($user);
            
        } catch (\Exception $e) {
            return redirect()->route('threads.index')
                ->with('flash', 'Unknown token.');
        }
        
        return redirect()->route('threads.index')
            ->with('flash', 'Your account is now confirmed! You may post to the forum.');
    }
}

