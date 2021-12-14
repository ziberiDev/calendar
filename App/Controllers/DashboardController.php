<?php

namespace App\Controllers;

use App\Core\Calendar;
use App\Core\Database\QueryBuilder;
use App\Core\Request\Request;
use App\Core\Session\Session;
use App\Core\View\View;


class DashboardController extends Controller
{
    public function __construct(protected Calendar $calendar, View $view, Request $request, QueryBuilder $db)
    {
        if (!Session::get('user')) return header('Location:login');
        parent::__construct($view, $db, $request);
    }

    public function index()
    {
        $this->calendar->initializeFromDate(date('Y-m-d'));
        $this->calendar->renderDays();
        return $this->view->renderView('dashboard.index');
    }

}