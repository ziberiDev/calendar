<?php

namespace App\Controllers;

use App\Core\Calendar;
use App\Core\Request\Request;
use App\Core\Session\Session;

class CalendarController extends Controller
{
    protected Calendar $calendar;

    public function __construct()
    {
        parent::__construct();
        $this->calendar = new Calendar();
    }

    public function authUserCalendar()
    {
        $request = new Request();
        $events = $this->select()->from('events')
            ->where('user_id', '=', Session::get('user')->id)
            ->andWhere('event_date', "LIKE", "%{$request->getParams()->date}%")
            ->get();

        $this->calendar->initializeFromDate($request->getParams()->date);
        $this->calendar->renderDays();

        $this->calendar->setEvents($events);

        return $this->calendar->toJson();

        /*return $this->renderView('auth.index', ['daysOfWeek' => $daysOfWeek]);*/
    }
}