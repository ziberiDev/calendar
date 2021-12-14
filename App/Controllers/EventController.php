<?php

namespace App\Controllers;

use App\Core\Calendar;
use App\Core\Database\QueryBuilder;
use App\Core\Request\Request;
use App\Core\Session\Session;
use App\Core\View\View;
use http\Header;
use function DI\get;


class EventController extends Controller
{
    public function __construct(View $view, QueryBuilder $db, Request $request,)
    {
        if (!Session::get('user')) return header('Location:login');
        parent::__construct($view, $db, $request);

    }

    public function create()
    {
        $this->request->validate([
            'title' => 'required',
            'description' => 'optional',
            'event_date' => 'required'
        ]);
        if ($this->request->isValid()) {
            $params = array_merge($this->request->all(), ['user_id' => Session::get('user')->id]);
            $this->db->insert('events', $params)->execute();
        }
    }
}