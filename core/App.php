<?php

namespace Core;

class App
{
    public Router $router;

    public function __construct()
    {
        $db = Database::getInstance();
        $db->connect();

        $this->router = Router::getInstance();
    }

    public function run(): void
    {
        $this->router->setRequest(new Request());
        $this->router->setView(new View());
        $this->router->setResponse(new Response());
        $this->router->setValidation(new Validation());
        $this->router->setSession(new Session());

        $this->router->run();
    }
}
