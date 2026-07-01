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
        unset($_SESSION['errors']);

        $next();
    }
}
  