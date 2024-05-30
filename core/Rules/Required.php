<?php

namespace Core\Rules;

class Required extends Rule
{
    public function validate(): string
    {
        $message = "Field " . $this->attribute . " harus diisi.";

        if (is_null($this->value)) {
            return $message;
        } elseif (is_string($this->value) && trim($this->value) === '') {
            return $message;
        }

        return "";
    }
}
