<?php

namespace App\Controllers;

use Core\Request;
use Core\Response;
use Core\Session;
use Core\Validation;
use Core\View;

class Controller
{
    public Request $request;
    public Response $response;
    public Session $session;
    public Validation $validation;
    public View $view;

    public function init(
        Request $request,
        Response $response,
        Session $session,
        Validation $validation,
        View $view,
    ) {
        $this->request = $request;
        $this->response = $response;
        $this->session = $session;
        $this->validation = $validation;
        $this->view = $view;
    }

    public function render(string $path, array $data = []): string
    {
        return $this->view->render($path, [
            ...[
                "request" => $this->request,
                "response" => $this->response,
                "session" => $this->session,
                "view" => $this->view,
            ],
            ...$data
        ]);
    }
}
