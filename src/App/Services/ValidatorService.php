<?php

declare(strict_types=1);

namespace App\Services;

use Framework\Rules\{
    EmailRule, 
    RequiredRule, 
    MinRule
};
use Framework\Validator;

class ValidatorService{
    public function __construct(
        private Validator $validator = new Validator(),
    )
    {
        $this->validator->add('required', new RequiredRule());
        $this->validator->add('email', new EmailRule());
        $this->validator->add('min', new MinRule());
    }

    public function validateRegister(array $formData) : void {
        $this->validator->validate($formData, [
            'email' => ['required', 'email'],
            'age' => ['required', 'min:18'],
            'country' => ['required'],
            'social_media_url' => ['required'],
            'password' => ['required'],
            'conf_password' => ['required'],
            'is_terms_accepted' => ['required'],
        ]);
    }
}