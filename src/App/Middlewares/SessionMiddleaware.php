<?php

declare(strict_types=1);

namespace App\Middlewares;

use App\Exceptions\SessionException;
use Framework\Contracts\MiddlewareInterface;
use Override;

class SessionMiddleaware implements MiddlewareInterface
{
    #[Override]
    public function process(callable $next)
    {
        if (session_status() === PHP_SESSION_ACTIVE) {
            throw new SessionException("Session alreay active.");
        }

        if (headers_sent($filename, $line)) {
            throw new SessionException("Header already sent. Consider enable ouput buffering. Data Outputted from $filename - Line: $line");
        }

        session_start();
        
        $next();

        session_write_close();
    }
}
