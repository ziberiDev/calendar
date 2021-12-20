<?php

use App\Controllers\{AuthenticationController, CalendarController, DashboardController, EventController};
use App\Core\Router\Router;

/** @var Router $router */
$router->get("", controller: [DashboardController::class, 'index']);

$router->get('authUser/calendar', controller: [CalendarController::class, 'authUserCalendar']);

$router->post('event/create', controller: [EventController::class, 'create']);

$router->post('event/update', controller: [EventController::class, 'update']);
require_once 'auth.php';


