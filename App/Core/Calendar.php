<?php

namespace App\Core;

use App\Core\View\Collection;
use DateTime;

class Calendar
{
    protected const calendar = CAL_GREGORIAN;

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
            $day_date = date('Y-m-d', strtotime("{$this->currentYear}-{$this->currentMonth}-$i"));
            $this->data[$i] = [
                'date' => $day_date,
                'day_string' => $day_of_week,
                'events' => []
            ];
        }
    }

    public function setEvents(Collection $events)
    {
        for ($i = 1; $i <= count($this->data); $i++) {
            foreach ($events as $event) {
                $eventDate = new DateTime($event->event_date);
                if ($this->data[$i]['date'] == $eventDate->format('Y-m-d')) {
                    $this->data[$i]['events'][] = $event;
                }
            }
        }

    }

    public function toJson()
    {
        echo json_encode([
            "year" => $this->currentYear,
            "month" => date('M', strtotime("{$this->currentYear}-{$this->currentMonth}")),
            "calendar" => $this->data,
        ]);
    }

}