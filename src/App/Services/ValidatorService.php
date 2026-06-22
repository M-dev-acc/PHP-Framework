<?php

declare(strict_types=1);

namespace App\Services;

use Framework\Rules\RequiredRule;
use Framework\Validator;

class ValidatorService{
    public function __construct(
        private Validator $validator = new Validator(),
    )
    {
        $this->validator->add('required', new RequiredRule());
    }

    public function validateRegister(array $formData) : void {
        $this->validator->validate($formData, [
            'email' => ['required'],
            'age' => ['required'],
            'country' => ['required'],
            'social_media_url' => ['required'],
            'password' => ['required'],
            'conf_password' => ['required'],
            'is_terms_accepted' => ['required'],
        ]);
    }
}