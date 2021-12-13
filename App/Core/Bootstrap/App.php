<?php

namespace App\Core\Bootstrap;

use App\Core\Request\Request;
use App\Core\Router\Router;
use Dotenv\Dotenv;

class App
{
    protected Dotenv $env;


    public function __construct()
    {
        $this->env = Dotenv::createImmutable("./");
        $this->env->load();
        $this->env->required(['DB_HOST', 'DB_NAME', 'DB_USER'])->notEmpty();
    }


    public function initialize()
    {
        Router::load()
            ->direct(Request::uri(), Request::method());
    }

}