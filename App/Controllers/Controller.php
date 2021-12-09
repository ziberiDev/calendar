<?php

namespace App\Controllers;

use App\Core\Authentication\Authentication;
use App\Core\Database\QueryBuilder;
use App\Core\View\View;

class Controller extends View
{
    use QueryBuilder;

    public function __construct()
    {
        parent::__construct();
        $this->__QueryBuilderConstruct();
    }
}