<?php

declare(strict_types=1);

namespace App\Middlewares;

use Framework\Contracts\MiddlewareInterface;
use Framework\Exceptions\ValidationException;
use Override;

class ValidationExceptionMiddleware implements MiddlewareInterface{
    
    public function process(callable $next)
    {
        try {
            $next();
        } catch (ValidationException $th) {
            $referer = $_SERVER['HTTP_REFERER'];

            redirect($referer);
        }
    }
}