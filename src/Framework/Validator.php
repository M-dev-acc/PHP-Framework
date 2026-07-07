<?php

declare(strict_types=1);

namespace Framework;

use Framework\Contracts\RulesInterface;
use Framework\Exceptions\ValidationException;

class Validator
{
    private array $rules = [];

    public function add(string $alias, RulesInterface $rule): void
    {
        $this->rules[$alias] = $rule;
    }

    public function validate(array $formData, array $fields): void
    {
        $errors = [];
        $ruleParams = [];
        foreach ($fields as $field => $rules) {
            foreach ($rules as $rule) {
                if (str_contains($rule, ':')) {
                    [$rule, $ruleParams] = explode(':', $rule);
                    $ruleParams = explode(',', $ruleParams);
                }

                $ruleValidator = $this->rules[$rule];

                if ($ruleValidator->validate($formData, $field, $ruleParams)) {
                    continue;
                }
                $errors[$field][] = $ruleValidator->getMessage(
                    $formData,
                    $field,
                    $ruleParams
                );
            }
        }

        if (count($errors)) {
            throw new ValidationException($errors);
        }
    }
}
