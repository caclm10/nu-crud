<?php

namespace Core\Rules;

class Numeric extends Rule
{
    public function validate(): string
    {
        $message = "Field " . $this->attribute . " hanya dapat berupa angka.";

        if (is_numeric($this->value)) {
            return "";
        }

        return $message;
    }
}
