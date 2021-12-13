<?php

use App\Core\Request\Request;
use App\Core\Router\Router;

require_once './vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->safeLoad();

$session = new \App\Core\Session\Session();
$session->start();


try {
    Router::load()
        ->direct(Request::uri(), Request::method());
} catch (Throwable $th) {
    var_dump(Request::uri());
    echo $th->getMessage();
}






