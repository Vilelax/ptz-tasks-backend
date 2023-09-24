<?php

require __DIR__."/bootstrap.php";

use CoffeeCode\Router\Router;

$router = new Router("https://localhost/potenza-tasks");

$router->namespace("Source\App");

//App routes
$router->get("/", "TaskController:index");

$router->get("/tasks", "TaskController:index");

$router->get("/task/{id}", "TaskController:task");

$router->post("/task/create", "TaskController:create");

$router->post("/task/update/{id}", "TaskController:update");

$router->post("/task/complete/{id}", "TaskController:complete");


//Error route
$router->get("/error/{code}", "TaskController:httpError");


//Dispatcher
$router->dispatch();


if ($router->error()) {
    $router->redirect("/error/{$router->error()}");
}
