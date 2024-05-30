<?php

namespace Core;

use Support\Singleton;

class Router extends Singleton
{
    public Response $response;
    public Request $request;
    public Session $session;
    public Validation $validation;
    public View $view;

    private array $routes = [];

    public function checkRoute(string $path, string $method): bool
    {
        $route = null;
        if (isset($this->routes[$path])) {
            $route = $this->routes[$path];
        }

        return $route && $route["method"] == $method;
    }

    public function getDetails(string $path, bool $index)
    {
        $exploded = array_slice(explode("/", $path), 1);

        if (count($exploded) < 2 && (count($exploded) == 1 && !$index)) {
            $this->response->setStatusCode(500);
            echo "Controller or method not found.";
            exit;
        }

        $controller = $exploded[0];
        $method = null;
        $params = [];

        if ($index) {
            $method = "index";
            $params = array_slice($exploded, 1);
        } else {
            $method = $exploded[1];
            $params = array_slice($exploded, 2);
        }

        return [
            "controller" => $controller,
            "method" => $method,
            "params" => $params
        ];
    }

    public function get(string $path, bool $index = false): void
    {
        $route = $this->getDetails($path, $index);

        $data = [
            "method" => "get",
            "index" => $index,
            "controller" => $route["controller"],
            "controllerMethod" => $route["method"],
        ];

        $this->routes["/" . $route["controller"] . "/" . $route["method"]] = $data;

        if ($index) {
            $this->routes["/" . $route["controller"]] = $data;
        }
    }

    public function post(string $path, bool $index = false): void
    {
        $route = $this->getDetails($path, $index);

        $data = [
            "method" => "post",
            "index" => $index,
            "controller" => $route["controller"],
            "controllerMethod" => $route["method"],
        ];

        $this->routes["/" . $route["controller"] . "/" . $route["method"]] = $data;

        if ($index) {
            $this->routes["/" . $route["controller"]] = $data;
        }
    }

    public function run(): mixed
    {
        $path = $this->request->getPath();
        $method = $this->request->getMethod();

        if ($path == "/") {
            $this->response->redirect("/home");
        }

        $pathFragment = array_slice(explode("/", $path), 1);

        $mainPath = "/" . $pathFragment[0];
        if (count($pathFragment) >= 2) {
            $mainPath .= "/" . $pathFragment[1];
        }

        $isRouteExists = $this->checkRoute($mainPath, $method);

        if (!$isRouteExists && count($pathFragment) == 2) {
            $mainPath = "/" . $pathFragment[0];

            $isRouteExists = $this->checkRoute($mainPath, $method);
        }

        if (!$isRouteExists) {
            $this->response->setStatusCode(404);
            echo $this->view->render("404");
            exit;
        }

        $route = $this->routes[$mainPath];

        $controller = ucfirst($route["controller"]);
        $controllerMethod = $route["controllerMethod"];
        $params = $this->getDetails($path, $route["index"])["params"];

        $controllerClass = "App\\Controllers\\" . $controller;

        if (!class_exists($controllerClass)) {
            $this->response->setStatusCode(404);
            echo $this->view->render("404");
            exit;
        }

        if (!method_exists($controllerClass, $controllerMethod)) {
            $this->response->setStatusCode(404);
            echo $this->view->render("404");
            exit;
        }

        $controllerObject = new $controllerClass();

        $controllerObject->init(
            $this->request,
            $this->response,
            $this->session,
            $this->validation,
            $this->view
        );


        echo $controllerObject->$controllerMethod(...$params);

        if (!$this->request->isFetch()) {
            $this->session->set("prev_url", $_SERVER['REQUEST_URI']);
            $this->session->clearFlashdata();
            $this->session->clearOld();
        }
        return null;
    }

    public function setResponse(Response $response): void
    {
        $this->response = $response;
    }

    public function setRequest(Request $request): void
    {
        $this->request = $request;
    }

    public function setSession(Session $session): void
    {
        $this->session = $session;
    }

    public function setValidation(Validation $validation): void
    {
        $this->validation = $validation;
    }

    public function setView(View $view): void
    {
        $this->view = $view;
    }

    public static function getInstance(): self
    {
        return parent::getInstance();
    }
}
