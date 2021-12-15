<?php

namespace App\Controllers;

use App\Core\CalendarService;
use App\Core\Database\QueryBuilder;
use App\Core\Helpers\Redirect;
use App\Core\Request\Request;
use App\Core\Response\Response;
use App\Core\Session\Session;
use App\Core\View\View;


class DashboardController extends Controller
{
    public function __construct(protected CalendarService $calendar, View $view, Request $request, QueryBuilder $db, Response $response)
    {
        if (!Session::get('user')) Redirect::to('login');
        parent::__construct($view, $db, $request, $response);
    }

    public function index()
    {
        $this->calendar->initializeFromDate(date('Y-m-d'));
        $this->calendar->renderDays();
        return $this->view->renderView('dashboard.index');
    }

}