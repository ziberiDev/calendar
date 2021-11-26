<?php

namespace App\Core\Bootstrap;

use App\Core\Request\Request;
use App\Core\Router\Router;
use Dotenv\Dotenv;

class App
{
    protected $env;


    public function __construct()
    {
        $this->env = Dotenv::createImmutable("./");
        $this->env->load();
        $this->env->required(['DB_HOST', 'DB_NAME', 'DB_USER'])->notEmpty();
    }

    public static function env($constantName)
    {
        echo getenv($constantName);
    }

    public function initialize()
    {
        Router::loadWebRoutes()
            ->direct(Request::uri(), Request::method());
    }

}