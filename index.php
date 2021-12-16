<?php

use App\Core\Bootstrap\Facade\App;
use App\Core\Request\Request;
use App\Core\Router\Router;


require_once './vendor/autoload.php';

// Env file configuration and loading.
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->safeLoad();

// Initialize Session for app.
$session = App::get('Session');
$session->start();


try {
    //Load route routes and initialize routing.
    Router::load()
        ->direct(Request::uri(), Request::method());
} catch (Exception $th) {
    //TODO: Log error messages here
    $handler = new \App\Core\Exceptions\ExceptionHandler($th);
    $handler->handle();
}






