<?php

declare(strict_types=1);

namespace Framework\Exceptions;

use Override;
use RuntimeException;
use Throwable;

class ValidationException extends RuntimeException
{
    public function __construct(int $code = 422)
    {
        return parent::__construct(code: $code);
    }
}