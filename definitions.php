<?php

use App\Core\Database\QueryBuilder;
use App\Core\Request\Request;
use App\Core\View\View;
use function DI\get;

return [
    'Request' => \DI\autowire(Request::class),
    'View' => \DI\autowire(View::class),
    'QueryBuilder' => \DI\autowire(QueryBuilder::class),
    'Session' => \DI\autowire(\App\Core\Session\Session::class)
];