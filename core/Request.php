<?php

namespace Core;

class Request
{
    public function getPath(): string
    {
        $path = $_SERVER["PATH_INFO"] ?? "/";

        $path = str_replace("/index.php", "", $path);

        if ($path == "" || $path == "//") {
            $path = "/";
        }

        return $path;
    }

    public function getMethod(): string
    {
        return strtolower($_SERVER["REQUEST_METHOD"]);
    }

    public function getPost(?string $key = null): mixed
    {
        if ($key) {
            return $_POST[$key];
        }

        return $_POST;
    }

    public function getFile(string $key)
    {
        return $_FILES[$key];
    }

    public function getQuery(string $key, string $default = ""): string
    {
        $fullQueryString = $_SERVER["QUERY_STRING"];
        $queryStringFragment = explode("&", $fullQueryString);

        if ($queryStringFragment[0] == "") return $default;

        foreach ($queryStringFragment as $queryString) {
            $queryFragment = explode("=", $queryString);

            if ($queryFragment[0] == $key && isset($queryFragment[1]) && $queryFragment[1] != "") {
                return $queryFragment[1];
            }
        }

        return $default;
    }

    public function isFetch(): bool
    {
        return isset($_SERVER["HTTP_X_REQUESTED_WITH"]) && $_SERVER["HTTP_X_REQUESTED_WITH"] == "Fetch";
    }
}
