<?php

namespace Support;

class ValidationError
{
    protected array $data = [];

    public function __construct(array $data = [])
    {
        $this->data = $data;
    }

    public function has(string $key): bool
    {
        return isset($this->data[$key]);
    }

    public function get(string $key): string|null
    {
        return $this->has($key) ? $this->data[$key] : null;
    }

    public function any(): bool
    {
        return count($this->data) > 0;
    }

    public function add(string $key, string $value): void
    {
        $this->data[$key] = $value;
    }
}
