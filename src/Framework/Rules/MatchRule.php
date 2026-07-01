<?php

declare(strict_types=1);

namespace Framework\Rules;

use Framework\Contracts\RulesInterface;
use InvalidArgumentException;
use Override;

class MatchRule implements RulesInterface
{
    #[Override]
    public function validate(array $data, string $field, array $params): bool
    {
        if (!isset($data[$params[0]])) {
            throw new InvalidArgumentException("Matching field does not exists");
        }

        return $data[$field] === $data[$params[0]];
    }

    #[Override]
    public function getMessage(array $data, string $field, array $params): string
    {
        return "Does not match $params[0] field";
    }
}
