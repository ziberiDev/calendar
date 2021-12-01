<?php

namespace App\Controllers;

use App\Core\Calendar;
use App\Core\Database\QueryBuilder;
use Illuminate\Support\Facades\DB;
use JetBrains\PhpStorm\Pure;

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
        $db->insert('users', [
            [
                'first_name' => 'ajkna',
                'last_name' => 'asd',
                'password' => 'asd',
                'email' => "denis@test.com"
            ],
            [
                'first_name' => 'ajkna',
                'last_name' => 'asdaaaaa',
                'password' => 'asd',
                'email' => "denis@test.com"
            ],
            [
                'first_name' => 'ajkna',
                'last_name' => 'denis',
                'password' => 'asd',
                'email' => "denis@test.com"
            ]
        ])->execute();
        echo "<pre>";
        $this->calendar->initializeFromDate("2021-12");
        $this->calendar->renderDays();
        $daysOfWeek = $this->calendar->daysOfWeek;
//        $this->calendar->toJson();
        echo "</pre>";
        /*return $this->renderView('homepage.index', ['daysOfWeek' => $daysOfWeek]);*/
    }
}