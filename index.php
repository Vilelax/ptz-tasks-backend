<?php

require __DIR__."/bootstrap.php";

use CoffeeCode\Router\Router;

$router = new Router("https://localhost/ptz-tasks");

$router->namespace("Source\App");

//App routes
$router->group("/app");

$router->get("/", "TaskController:index");

$router->get("/tasks", "TaskController:index");

$router->get("/task/{id}", "TaskController:task");

$router->post("/task/create", "TaskController:create");

$router->post("/task/update", "TaskController:update");

$router->get("/task/complete/{id}", "TaskController:complete");


//Error route
$router->get("/error/{code}", "TaskController:Error");


//Dispatcher
$router->dispatch();


if ($router->error()) {
    $router->redirect("app/error/{$router->error()}");
}
