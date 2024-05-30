<?php

namespace Core\Rules;

class RequiredFile extends Rule
{
    public function validate(): string
    {
        $message = "Field " . $this->attribute . " harus diisi.";

        if (!file_exists($this->value['tmp_name']) || !is_uploaded_file($this->value['tmp_name'])) {
            return $message;
        }

        return "";
    }
}
