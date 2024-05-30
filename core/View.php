<?php

namespace Core;

class View
{
    protected string $basePath;

    public function __construct(string $basePath = __DIR__ . "/../views/")
    {
        $this->basePath = $basePath;
    }

    public function render(string $path, array $data = []): string
    {
        foreach ($data as $key => $value) {
            $$key = $value;
        }

        ob_start();
        include $this->basePath . $path . ".php";
        return ob_get_clean();
    }
}
