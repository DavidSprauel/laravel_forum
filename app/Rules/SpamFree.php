<?php

namespace Forum\Rules;

use Forum\Library\Inspections\Spam;
use Illuminate\Contracts\Validation\Rule;

class SpamFree implements Rule {
    
    public function passes($attribute, $value) {
        try {
            return ! resolve(Spam::class)->detect($value);
        } catch (\Exception $e) {
            return false;
        }
    }
    
    public function message() {
        return trans('validation.spamfree');
    }
}
