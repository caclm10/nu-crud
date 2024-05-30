<?php

use Core\Router;

$router = Router::getInstance();

$router->get("/home", true);
$router->get("/barang", true);
$router->post("/barang/store");
$router->get("/barang/edit");
$router->post("/barang/update");
$router->post("/barang/destroy");
