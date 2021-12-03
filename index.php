<?php

use App\Core\Request\Request;
use App\Core\Router\Router;

require_once './vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->safeLoad();
//var_dump(range( 2021, 2031));
//var_dump(cal_days_in_month(CAL_GREGORIAN , 2 , 2019));//get days of given month of a given year
$date = new DateTime();

$session = new \App\Core\Session\Session();
$session->start();

try {

    Router::loadWebRoutes()
        ->direct(Request::uri(), Request::method());
} catch (Throwable $th) {
    var_dump(Request::uri());
    echo $th->getMessage();
}






