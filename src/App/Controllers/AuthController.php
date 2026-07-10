<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Services\{
    ValidatorService, 
    UserService
};
use Framework\TemplateEngine;

class AuthController
{
    public function __construct(
        private TemplateEngine $view,
        private ValidatorService $validator,
        private UserService $userService,
    ) {
    }

    public function registerView(): void
    {
        echo $this->view->render('register.phtml', []);
    }

    public function register(): void
    {
        $this->validator->validateRegister($_POST);
        $this->userService->checkEmailExists($_POST['email']);
        
        $this->userService->create($_POST);

        redirect('/');
    }
}
