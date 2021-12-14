<?php

use App\Core\Bootstrap\Facade\App;
use App\Core\Request\Request;
use App\Core\Router\Router;


require_once './vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->safeLoad();

$session = App::get('Session');
$session->start();

try {
    Router::load()
        ->direct(Request::uri(), Request::method());
} catch (Throwable $th) {
    echo $th->getMessage();
}






