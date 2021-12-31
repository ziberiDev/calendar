<?php

namespace App\Middleware;

use App\Core\Contracts\MiddlewareContract;
use App\Core\Enums\Role;
use App\Core\Middleware\Middleware;
use App\Core\Session\Session;

class CanUpdateUserEventMiddleware extends Middleware implements MiddlewareContract
{

    public function handle()
    {
        $params = $this->request->getParams();

        if (intval($params->event_user_id) !== Session::get('user')->id) {
            echo 'Not my event';
            if (!Role::from(Session::get('user')->role_id)->canUpdate()) {
               return  $this->response('User has no permissions for this action', 403);
            };
        }
    }
}