<?php

use App\Core\Bootstrap\Facade\App;
use App\Core\Request\Request;
use App\Core\Router\Router;


require_once './vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->safeLoad();

$data = [
    'message' => 'success',
    "code" => 500
];

/*http_response_code("500");
file_get_contents("https://google.com");
header('Content-Type: application-json;charset=utf-8');


die();*/
$session = App::get('Session');
$session->start();

try {
    Router::load()
        ->direct(Request::uri(), Request::method());

} catch (Throwable $th) {
    echo $th->getMessage();
}






