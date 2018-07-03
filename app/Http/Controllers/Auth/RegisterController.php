<?php

namespace Forum\Http\Controllers\Auth;

use Forum\Mail\PleaseConfirmYourEmail;
use Forum\Models\Entities\Eloquent\User;
use Forum\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Mail;

class RegisterController extends Controller {
    
    use RegistersUsers;
    
    protected $redirectTo = '/home';
    
    public function __construct() {
        $this->middleware('guest');
    }
    
    protected function validator(array $data) {
        return Validator::make($data, [
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);
    }
    
    protected function create(array $data) {
        return User::create([
            'name'               => $data['name'],
            'email'              => $data['email'],
            'password'           => bcrypt($data['password']),
            'confirmation_token' => str_limit(md5($data['email'] . str_random()), 25, '')
        ]);
    }
    
    protected function registered(Request $request, $user) {
        Mail::to($user)->send(new PleaseConfirmYourEmail($user));
        
        return redirect($this->redirectPath());
    }
}
