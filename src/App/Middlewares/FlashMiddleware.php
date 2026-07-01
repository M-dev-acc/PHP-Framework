<?php

declare(strict_types=1);

namespace App\Middlewares;

use Framework\Contracts\MiddlewareInterface;
use Framework\TemplateEngine;
use Override;

class FlashMiddleware implements MiddlewareInterface
{
    public function __construct(
        private TemplateEngine $view 
    )
    {}

    public function process(callable $next)
    {
        $this->view->addGlobal('errors', $_SESSION['errors'] ?? []);
        $this->view->addGlobal('oldFormData', $_SESSION['old_form_data'] ?? []);
        unset($_SESSION['errors']);
        unset($_SESSION['old_form_data']);

        $next();
    }
}
  