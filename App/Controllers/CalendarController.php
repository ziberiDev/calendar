<?php

namespace App\Controllers;

use App\Core\Calendar;
use App\Core\Database\QueryBuilder;
use App\Core\Request\Request;
use App\Core\Session\Session;
use App\Core\View\View;

class CalendarController extends Controller
{
    public function __construct(protected Calendar $calendar, View $view, Request $request, QueryBuilder $db)
    {
        if (!Session::get('user')) return header('Location:login');
        parent::__construct($view, $db, $request);
    }

    public function authUserCalendar()
    {
        $events = $this->db->select()->from('events')
            ->where('user_id', '=', Session::get('user')->id)
            ->andWhere('event_date', "LIKE", "%{$this->request->getParams()->date}%")
            ->get();

        $this->calendar->initializeFromDate($this->request->getParams()->date);
        $this->calendar->renderDays();

        $this->calendar->setEvents($events);

        return $this->calendar->toJson();

        /*return $this->renderView('auth.index', ['daysOfWeek' => $daysOfWeek]);*/
    }
}