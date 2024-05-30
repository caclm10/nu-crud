<?php

namespace Core;

use Support\ValidationError;

class Session
{
    public function __construct()
    {
        session_start();
    }

    public function set(string $key, mixed $value): void
    {
        $_SESSION[$key] = $value;
    }

    public function get(string $key, mixed $default = null): mixed
    {
        return $_SESSION[$key] ?? $default;
    }

    public function setFlashdata(string $key, mixed $value): void
    {
        $_SESSION["flash"] = [
            $key => $value,
        ];
    }

    public function getFlashdata(string $key): mixed
    {
        return (isset($_SESSION["flash"]) && isset($_SESSION["flash"][$key])) ? $_SESSION["flash"][$key] : null;
    }

    public function clearFlashdata(): void
    {
        $_SESSION["flash"] = null;
    }

    public function getValidationErrors(): ValidationError|null
    {
        return $this->getFlashdata("validation_errors") ?: new ValidationError();
    }

    public function setOld(array $data): void
    {
        $_SESSION["old"] = $data;
    }

    public function getOld(string $key, string $default = ''): string
    {
        return isset($_SESSION["old"][$key]) ? $_SESSION["old"][$key] : $default;
    }

    public function clearOld(): void
    {
        $_SESSION["old"] = [];
    }
}
