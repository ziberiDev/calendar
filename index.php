<?php

use App\Core\Bootstrap\Facade\App;
use App\Core\Exceptions\ExceptionHandler;
use App\Core\Exceptions\ExceptionLogger;
use App\Core\Request\Request;
use App\Core\Router\Router;


require_once './vendor/autoload.php';
function errorLogger($code, $msg, $file, $line, $context)
{
    echo $msg . PHP_EOL;
    echo $code . PHP_EOL;
   /* echo $file . PHP_EOL;*/
    echo $line . PHP_EOL;
    echo $context . PHP_EOL;

    exit();

}

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

    $handler = new ExceptionHandler($th, new ExceptionLogger());
    $handler->handle();
}






