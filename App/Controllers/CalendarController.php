<?php

namespace App\Controllers;

use App\Core\{CalendarService, Database\QueryBuilder, Request\Request, Response\Response, Session\Session, View\View};

class CalendarController extends Controller
{
    public function __construct(protected CalendarService $calendar, View $view, Request $request, QueryBuilder $db, Response $response)
    {
        parent::__construct($view, $db, $request, $response);
    }

    public function userCalendar()
    {

        $events = $this->db->select()->from('events')
            ->where('user_id', '=', $this->request->getParams()->id ?? Session::get('user')->id)
            ->andWhere('event_date', "LIKE", "%{$this->request->getParams()->date}%")
            ->get();

        $this->calendar->initializeFromDate($this->request->getParams()->date);
        $this->calendar->renderDays();
        $this->calendar->setEvents($events ?? []);


       return  $this->response($this->calendar->toJson());

    }

}