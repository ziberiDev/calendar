<?php

namespace App\Middleware;

use App\Core\Contracts\MiddlewareContract;
use App\Core\Enums\Role;
use App\Core\Middleware\Middleware;
use App\Core\Session\Session;

class CanCreateUserMiddleware extends Middleware implements MiddlewareContract
{

    public function handle()
    {
        if (!Role::from(Session::get('user')->role_id)->canCreateUser()) {
            return $this->response('User has no permissions for this action', 403);
        }
    }
}