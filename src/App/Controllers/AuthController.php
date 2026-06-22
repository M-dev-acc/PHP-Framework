<?php

declare(strict_types=1);

namespace App\Controllers;

use Framework\TemplateEngine;

class AuthController
{
    public function __construct(private TemplateEngine $view)
    {}

    public function registerView() : void {
        echo $this->view->render('register.phtml', []);
    }

    public function register() : void {
        dd($_POST);
    }
}
