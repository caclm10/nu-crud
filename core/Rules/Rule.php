<?php

namespace Core\Rules;

class Rule
{
    public string $attribute;
    public mixed $value;

    public function setAttribute(string $attribute): void
    {
        $this->attribute = $attribute;
    }

    public function setValue(mixed $value): void
    {
        $this->value = $value;
    }
}
