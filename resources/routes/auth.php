<?php

use App\Controllers\AuthenticationController;
use App\Core\Router\Router;

/** @var Router $router */

$router->get("login", controller: [AuthenticationController::class, 'index']);

$router->get('logout', controller: [AuthenticationController::class, 'logout'] ,middleware: ['auth']);

$router->post("login", controller: [AuthenticationController::class, 'login']);

$router->get("loginwithfacebook", controller: [AuthenticationController::class, 'facebooklogin']);

$router->get('register', controller: [AuthenticationController::class, 'registerForm']);

$router->post('register', controller: [AuthenticationController::class, 'register']);
