<?php

declare(strict_types=1);

namespace App\Services;

use Framework\Rules\{
    EmailRule,
    InRule,
    MatchRule,
    RequiredRule, 
    MinRule,
    UrlRule
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
        $this->validator->add('in', new InRule());
        $this->validator->add('url', new UrlRule());
        $this->validator->add('match', new MatchRule());
    }

    public function validateRegister(array $formData) : void {
        $this->validator->validate($formData, [
            'email' => ['required', 'email'],
            'age' => ['required', 'min:18'],
            'country' => ['required', 'in:USA,Canada,Mexico'],
            'social_media_url' => ['required', 'url'],
            'password' => ['required'],
            'conf_password' => ['required', 'match:password'],
            'is_terms_accepted' => ['required'],
        ]);
    }
}