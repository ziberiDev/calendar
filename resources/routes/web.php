<?php

use App\Controllers\{
    CalendarController,
    DashboardController,
    EventController,
    UsersController
};
use App\Core\Router\Router;

/** @var Router $router */
$router->post("test", controller: [DashboardController::class, 'test']);

$router->get("", controller: [DashboardController::class, 'index'], middleware: ['apiAuth']);

$router->get('authUser/calendar', controller: [CalendarController::class, 'userCalendar'], middleware: ['apiAuth']);

$router->post('event/create', controller: [EventController::class, 'create'], middleware: ['apiAuth', 'user_can_create_event']);

$router->post('event/update', controller: [EventController::class, 'update'], middleware: ['apiAuth', 'user_can_update_event']);

$router->post('event/delete', controller: [EventController::class, 'delete'], middleware: ['apiAuth', 'user_can_update_event']);

$router->get('users', controller: [UsersController::class, 'index'], middleware: ['apiAuth']);

$router->get('user/create', controller: [UsersController::class, 'create'], middleware: ['auth']);

$router->post('user/create', controller: [UsersController::class, 'store'], middleware: ['auth', 'can_create_user']);

require_once 'auth.php';



