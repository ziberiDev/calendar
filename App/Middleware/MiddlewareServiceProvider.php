<?php

namespace App\Middleware;


class MiddlewareServiceProvider
{
    protected array $kernel = [
        'auth' => AuthenticatedMiddleware::class,
        'apiAuth' => ApiAuthenticatedMiddleware::class,
        'isAdmin' => AdminMiddleware::class,
        'user_can_update_event' => CanUpdateUserEventMiddleware::class,
    ];

    public function __construct(array $middlewares)
    {
        if (empty($middlewares)) {
            return;
        }
        foreach ($middlewares as $middleware) {
            if (!array_key_exists($middleware, $this->kernel)) {
                throw  new \Exception("Middleware $middleware is not defined");
            }
            \App\Core\Bootstrap\Facade\App::get($this->kernel[$middleware])->handle();
        }
    }
}