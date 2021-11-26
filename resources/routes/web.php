<?php

use App\Controllers\UserController;
use App\Core\Router\Router;

/** @var Router $router */
$router->get("", controller: [UserController::class, 'index']);
$router->get("new_route", controller: [UserController::class, 'new']);