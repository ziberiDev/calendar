<?php

namespace App\Controllers;

use App\Core\Authentication\Authentication;
use App\Core\Database\QueryBuilder;
use App\Core\Request\Request;
use App\Core\View\View;


class Controller
{
    public function __construct(
        protected View         $view,
        protected QueryBuilder $db,
        protected Request      $request){}
}