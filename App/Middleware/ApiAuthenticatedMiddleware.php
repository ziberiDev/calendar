<?php

namespace App\Middleware;

use App\Core\Contracts\MiddlewareContract;
use App\Core\Middleware\Middleware;
use App\Core\Session\Session;

class ApiAuthenticatedMiddleware extends Middleware implements MiddlewareContract
{

    public function handle()
    {
        if (Session::get('user')) {
            return;
        }
        $this->response('Unauthenticated', 401);
    }
}