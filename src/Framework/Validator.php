<?php

declare(strict_types=1);

namespace Framework;

use Framework\Contracts\RulesInterface;

class Validator{
    private array $rules = [];

    public function add(string $alias, RulesInterface $rule) : void {
        $this->rules[$alias] = $rule;
    }

    public function validate(array $formData, array $fields) : void {
        foreach ($fields as $field => $rules) {
            foreach ($rules as $rule) {
                $ruleValidator = $this->rules[$rule];

                if ($ruleValidator->validate($formData, $field, [])) {
                    continue;
                }

                echo "Error";
            }
        }
    }
}