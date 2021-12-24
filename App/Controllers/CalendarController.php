<?php

namespace App\Controllers;

use App\Core\{CalendarService, Database\QueryBuilder, Request\Request, Response\Response, Session\Session, View\View};

class CalendarController extends Controller
{
    public function __construct(protected CalendarService $calendar, View $view, Request $request, QueryBuilder $db, Response $response)
    {
        parent::__construct($view, $db, $request, $response);
    }

    public function authUserCalendar()
    {
        if (!Session::get('user')) return $this->response('Unauthenticated', 401);

        $events = $this->db->select()->from('events')
            ->where('user_id', '=', Session::get('user')->id)
            ->andWhere('event_date', "LIKE", "%{$this->request->getParams()->date}%")
            ->get();

        $this->calendar->initializeFromDate($this->request->getParams()->date);
        $this->calendar->renderDays();
        $this->calendar->setEvents($events);

        return $this->response($this->calendar->toJson());
    }
}