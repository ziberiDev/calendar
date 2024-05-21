<?php

namespace App\Middleware;

use App\Core\Contracts\MiddlewareContract;
use App\Core\Helpers\Redirect;
use App\Core\Middleware\Middleware;
use App\Core\Request\Request;
use App\Core\Response\Response;
use App\Core\Session\Session;
use JetBrains\PhpStorm\Pure;

class AuthenticatedMiddleware extends Middleware implements MiddlewareContract
{


    public function handle()
    {
        if (Session::get('user')) {

           return;
        }
        Redirect::to('/login');
    }
}