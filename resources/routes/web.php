<?php

use App\Controllers\{AuthenticationController, CalendarController, DashboardController};
use App\Core\Router\Router;

/** @var Router $router */
$router->get("", controller: [AuthenticationController::class, 'index']);

$router->post("login", controller: [AuthenticationController::class, 'login']);

$router->get('register', controller: [AuthenticationController::class, 'registerForm']);

$router->post('register', controller: [AuthenticationController::class, 'register']);

$router->get("dashboard", controller: [DashboardController::class, 'index']);