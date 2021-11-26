<?php

use App\Core\Request\Request;
use App\Core\Router\Router;

require_once './vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->safeLoad();


try {
    Router::loadWebRoutes()
        ->direct(Request::uri(), Request::method());
} catch (Throwable $th) {
    echo $th->getMessage();
}





