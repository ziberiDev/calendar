<?php

use App\Core\Bootstrap\Facade\App;
use App\Core\Exceptions\ExceptionHandler;
use App\Core\Exceptions\ExceptionLogger;
use App\Core\Request\Request;
use App\Core\Router\Router;
use Calendarific\Calendarific;


require_once './vendor/autoload.php';
/*$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->safeLoad();
$key = '5f1994a49ffec9de1d1b434d98fcad235a49953e';
$country = 'MK';
$year = 2023;
$month = null;
$day = null;
$location = null;
$types = ['national'];

$dates = Calendarific::make(
    $key,
    $country,
    $year,
    $month,
    $day,
    $location,
    $types
);

$insertData = [];


foreach ($dates['response']['holidays'] as $holiday) {
    $insertData[] = [
        'name' => $holiday['name'],
        'description' => $holiday['description'],
        'date' => $holiday['date']['iso']
    ];
}*/
/*var_dump($insertData);
die();*/
/*$db = new \App\Core\Database\QueryBuilder();
$db->insert('holidays', $insertData)->execute(); */
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






