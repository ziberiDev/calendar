<?php

use App\Controllers\{AuthenticationController, CalendarController, DashboardController};
use App\Core\Router\Router;

/** @var Router $router */
$router->get("", controller: [DashboardController::class, 'index']);

$router->get('authUser/calendar', controller: [CalendarController::class, 'authUserCalendar']);

require_once 'auth.php';


