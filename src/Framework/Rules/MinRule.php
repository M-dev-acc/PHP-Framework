<?php

declare(strict_types=1);

namespace Framework\Rules;

use Framework\Contracts\RulesInterface;
use InvalidArgumentException;

class MinRule implements RulesInterface
{
    #[Override]
    public function validate(array $data, string $field, array $params): bool
    {
        if(empty($params[0])){
            throw new InvalidArgumentException("Minimum length not specified.");
        }

        $length = (int) $params[0];
        return $data[$field] >= $length;
    }

    #[Override]
    public function getMessage(array $data, string $field, array $params): string
    {
        return "Must be at least {$params[0]}";
    }
}
