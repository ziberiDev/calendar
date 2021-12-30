<?php

namespace App\Middleware;

use App\Core\Contracts\MiddlewareContract;
use App\Core\Middleware\Middleware;

class CanUpdateUserEventMiddleware extends Middleware implements MiddlewareContract
{

    public function handle()
    {
         var_dump($this->request->getParams());
         die();
    }
}