<?php

declare(strict_types=1);

namespace App\Middlewares;

use Framework\Contracts\MiddlewareInterface;
use Framework\Exceptions\ValidationException;
use Override;

class ValidationExceptionMiddleware implements MiddlewareInterface
{
    public function process(callable $next)
    {
        try {
            $next();
        } catch (ValidationException $th) {
            $oldFormData = $_POST;
            $excludedKeys = ['password', 'conf_password'];
            $formatedFormData = array_diff_key(
                $oldFormData,
                array_flip($excludedKeys)
            );

            $_SESSION['errors'] = $th->errors;
            $_SESSION['old_form_data'] = $formatedFormData;
            $referer = $_SERVER['HTTP_REFERER'];

            redirect($referer);
        }
    }
}
