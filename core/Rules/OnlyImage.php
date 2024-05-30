<?php

namespace Core\Rules;

class OnlyImage extends Rule
{
    protected array $allowed = [];

    public function __construct(
        array $allowed = ["image/jpeg", "image/png"]
    ) {
        $this->allowed = $allowed;
    }

    public function validate(): string
    {
        $message = "Field " . $this->attribute . " hanya dapat berupa gambar.";

        if (!$this->value["name"]) {
            return "";
        }

        if (in_array($this->value["type"], $this->allowed)) {
            return "";
        }

        return $message;
    }
}
