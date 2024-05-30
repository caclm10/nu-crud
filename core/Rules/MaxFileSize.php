<?php

namespace Core\Rules;

class MaxFileSize extends Rule
{
    public function __construct(
        protected int $size = 100,
    ) {
    }
    public function validate(): string
    {
        $message = "Ukuran file terlalu besar (maksimum {$this->size}KB)";

        if (file_exists($this->value['tmp_name']) && $this->value["size"] > ($this->size * 1024)) {
            return $message;
        }

        return "";
    }
}
