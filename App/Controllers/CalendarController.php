<?php

namespace App\Controllers;

use App\Core\Calendar;

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



        echo "<pre>";
        $this->calendar->initializeFromDate("2021-12");
        $this->calendar->renderDays();
        $daysOfWeek = $this->calendar->daysOfWeek;
//        $this->calendar->toJson();
        echo "</pre>";
        /*return $this->renderView('auth.index', ['daysOfWeek' => $daysOfWeek]);*/
    }
}