<?php

namespace Forum\Rules;

use Illuminate\Contracts\Validation\Rule;
use Zttp\Zttp;

class Recaptcha implements Rule {
    
    public function passes($attribute, $value) {
        $response = Zttp::asFormParams()->post('https://www.google.com/recaptcha/api/siteverify', [
            'secret'   => config('services.recaptcha.secret'),
            'response' => $value,
            'remoteip' => request()->ip()
        ]);
    
        return $response->json()['success'];
    }
    
    public function message() {
        return 'The recaptcha verification failed. Try again.';
    }
}
