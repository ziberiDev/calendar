<?php

use App\Core\Bootstrap\Facade\App;
use App\Core\Exceptions\ExceptionHandler;
use App\Core\Exceptions\ExceptionLogger;
use App\Core\Request\Request;
use App\Core\Router\Router;
use Calendarific\Calendarific;
require_once './vendor/autoload.php';

try {
    // Env file configuration and loading.
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
    $dotenv->safeLoad();

    // Initialize Session for app.
    $session = App::get('Session');
    $session->start();
    //Load route routes and initialize routing.
    Router::load()
        ->direct(Request::uri(), Request::method());

} catch (Exception $e) {
    $handler = new ExceptionHandler($e, new ExceptionLogger());
    $handler->handle();
}






