<?php

namespace App\Core;

use App\Core\View\Collection;

class Calendar
{
    protected const calendar = CAL_GREGORIAN;

    public array $daysOfWeek = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'];

    public int $currentYear;

    public int $currentMonth;

    public array $data = [];

    protected int $numberOfDays;


    public function initializeFromDate(string $date)
    {
        $this->currentYear = (int)date("Y", strtotime("$date"));
        $this->currentMonth = (int)date('m', strtotime("$date"));
        $this->numberOfDays = cal_days_in_month(self::calendar, $this->currentMonth, $this->currentYear);
    }

    public function renderDays()
    {
        for ($i = 1; $i <= $this->numberOfDays; $i++) {
            $day_of_week = date('l', strtotime("{$this->currentYear}-{$this->currentMonth}-$i"));
            array_push($this->data, [
                'day' => $i,
                'day_string' => $day_of_week,
                'events' => []
            ]);
        }
    }

    public function setEvents(Collection $events)
    {
        foreach ($this->data as $day){

        }
    }

    public function toJson()
    {
        echo json_encode([
            "year" => $this->currentYear,
            "month" => $this->currentMonth,
            "data" => $this->data,
            "next" => $this->currentMonth + 1,
            "prev" => $this->currentMonth - 1
        ]);
    }

}