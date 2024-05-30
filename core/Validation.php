<?php

namespace Core;

use Support\ValidationError;

class Validation
{
    public function validate(array $payload): ValidationError
    {
        $errors = [];

        foreach ($payload as $attribute => $metadata) {
            $value = $metadata['value'];
            $rules = $metadata['rules'];
            $customAttributes = $metadata['attribute'] ?? null;

            foreach ($rules as $rule) {
                $rule->setValue($value);
                $rule->setAttribute($customAttributes ?: $attribute);

                $message = $rule->validate();
                if ($message) {
                    $errors[$attribute] = $message;
                    break;
                }
            }
        }

        return new ValidationError($errors);
    }
}
