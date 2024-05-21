<?php

namespace App\Middleware;

use App\Core\Contracts\MiddlewareContract;
use App\Core\Middleware\Middleware;
use App\Core\Session\Session;

class AdminMiddleware extends Middleware implements MiddlewareContract
{


    public function handle()
    {

        if (Session::get('user')->role_id == 2) {
            return;
        }
        // TODO: Implement handle() method.
        throw new \Exception('user is not Admin');
    }

}