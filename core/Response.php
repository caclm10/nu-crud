<?php

namespace Core;

class Response
{
    public function redirect(string $url)
    {
        $url = str_replace("/index.php", "", $url);
        header("location: /index.php" .  $url, true, 301);
        exit;
    }

    public function setStatusCode(int $code): void
    {
        http_response_code($code);
    }
}
