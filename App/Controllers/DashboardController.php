<?php

namespace App\Controllers;

use App\{Core\CalendarService,
    Core\Database\QueryBuilder,
    Core\Helpers\Redirect,
    Core\Request\Request,
    Core\Response\Response,
    Core\Session\Session,
    Core\View\View
};


class DashboardController extends Controller
{
    public function __construct(protected CalendarService $calendar, View $view, Request $request, QueryBuilder $db, Response $response)
    {
        if (!Session::get('user')) Redirect::to('login');
        parent::__construct($view, $db, $request, $response);
    }

    public function index()
    {
        return $this->view->renderView('dashboard.index');
    }

}