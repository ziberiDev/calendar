<?php

namespace App\Core;

use App\Core\Session\Session;
use App\Core\View\Collection;
use DateTime;

class CalendarService
{
    protected const calendar = CAL_GREGORIAN;

    protected const  dateFormat = "Y-m-d";

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
            $day_date = date(self::dateFormat, strtotime("{$this->currentYear}-{$this->currentMonth}-$i"));
            $this->data[$i] = [
                'date' => $day_date,
                'day_string' => $day_of_week,
                'events' => [],
                'holidays' => []
            ];
        }
    }

    public function setEvents(Collection|array $events)
    {
        for ($i = 1; $i <= count($this->data); $i++) {
            foreach ($events as $event) {
                $eventDate = new DateTime($event->event_date);
                if ($this->data[$i]['date'] == $eventDate->format(self::dateFormat)) {
                    $this->data[$i]['events'][] = $event;
                }
            }
        }
    }

    public function setHolidays(Collection|array $holidays)
    {
        for ($i = 1; $i <= count($this->data); $i++) {
            foreach ($holidays as $holiday) {
                $holidayDate = new DateTime($holiday->date);
                if ($this->data[$i]['date'] == $holidayDate->format(self::dateFormat)) {
                    $this->data[$i]['holidays'][] = $holiday;
                }
            }
        }
    }


    public function setVacationDays(Collection|array $user_vacations)
    {
        for ($i = 1; $i <= count($this->data); $i++) {
            foreach ($user_vacations as $vacation) {
                $vacation_start = new DateTime($vacation->start);
                $vacation_end = new DateTime($vacation->end);
                if ($this->data[$i]['date'] >= $vacation_start->format(self::dateFormat) && $this->data[$i]['date'] <= $vacation_end->format(self::dateFormat)) {
                    $this->data[$i]['onVacation'] = true;
                    break;
                }
                $this->data[$i]['onVacation'] = false;
            }
        }
    }

    public function toJson()
    {
        return json_encode([
            "user_vacation_days" => Session::get('user')->vacation_days,
            "year" => $this->currentYear,
            "month" => date('M', strtotime("{$this->currentYear}-{$this->currentMonth}")),
            "calendar" => $this->data,
        ]);
    }

    public function easter($year)
    {
        $G = $year; //godina
        $R1 = $G % 19; // G mod 19 (остаток при делење на годината со 19)
        $R2 = $G % 4; // G mod 4
        $R3 = $G % 7; // G mod 7
        $RA = (19 * $R1) + 16; // 19R1 + 16
        $R4 = $RA % 30; // RA mod 30
        $RB = (2 * $R2) + (4 * $R3) + (6 * $R4); // 2R2 + 4R3 + 6R4
        $R5 = $RB % 7; // RB mod 7
        $RC = $R4 + $R5; // R4 + R5

        if ($RC < 28) {
            $RC += 3;
            $month = '04';
        } else if ($RC >= 28) {
            $RC -= 27;
            $month = '05';
        }
        //TODO: refactor better vay of formatting the output date.
        $easter = "$month/$RC/$G 00:00:00";
        $easter = strtotime($easter);

        $date = date(self::dateFormat, $easter);
        return $date;

    }
}