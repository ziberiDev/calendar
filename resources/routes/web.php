<?php

use App\Controllers\{AuthenticationController, CalendarController, DashboardController, EventController};
use App\Core\Router\Router;

/** @var Router $router */
$router->post("test" , controller: [DashboardController::class , 'test']);

$router->get("", controller: [DashboardController::class, 'index']);

$router->get('authUser/calendar', controller: [CalendarController::class, 'authUserCalendar']);

$router->post('event/create', controller: [EventController::class, 'create']);

$router->post('event/update', controller: [EventController::class, 'update']);

$router->post('event/delete', controller: [EventController::class, 'delete']);
require_once 'auth.php';


