<?php

use App\Controllers\{AuthenticationController, CalendarController};
use App\Core\Router\Router;

/** @var Router $router */
$router->get("", controller: [AuthenticationController::class, 'index']);
$router->post("login", controller: [AuthenticationController::class, 'login']);
$router->get("new_route", controller: [CalendarController::class, 'new']);