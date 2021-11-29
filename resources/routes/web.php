<?php

use App\Controllers\CalendarController;
use App\Core\Router\Router;

/** @var Router $router */
$router->get("", controller: [CalendarController::class, 'index']);
$router->get("new_route", controller: [CalendarController::class, 'new']);