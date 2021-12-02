<?php

namespace App\Controllers;

use App\Core\Calendar;
use App\Core\Database\QueryBuilder;

class CalendarController extends Controller
{
    protected Calendar $calendar;

    public function __construct()
    {
        parent::__construct();
        $this->calendar = new Calendar();
    }

    public function index()
    {
        $db = new QueryBuilder();
        $users = $db->select('id')->from('users')->get();
        var_dump($users);
        $db->insert('events', [
            'user_id' => 1, 'date' => "2021-11-11 10:00:00"])->execute();
        echo "<pre>";
        $this->calendar->initializeFromDate("2021-12");
        $this->calendar->renderDays();
        $daysOfWeek = $this->calendar->daysOfWeek;
//        $this->calendar->toJson();
        echo "</pre>";
        /*return $this->renderView('homepage.index', ['daysOfWeek' => $daysOfWeek]);*/
    }
}