<?php

namespace App\Controllers;

use App\Core\Session\Session;
use DateTime;

class VacationController extends Controller
{

    protected const date_format = 'Y-m-d';

    public function create()
    {

        $validation = $this->request->validate([
            'start_date' => 'required',
            'duration' => 'required'
        ]);
        if (!$validation->isValid()) {
            return $this->response(json_encode($validation->getMessages()), 400);
        }
        $start_date = new DateTime($this->request->getParams()->start_date);
        $duration = $this->request->getParams()->duration;

        if (!$this->checkVacationByDate(new DateTime('now')) && !$this->checkVacationByDate($start_date) && (Session::get('user')->vacation_days >= $duration)) {

            $this->db->insert('user_vacations', [
                'user_id' => Session::get('user')->id,
                'start' => $start_date->format(self::date_format),
                'end' => $end = $this->getVacationEndDate($start_date, $duration)
            ])->execute();

            //Update user vacation days in database and session
            $this->db->update('users', [
                'vacation_days' => Session::get('user')->vacation_days -= $duration
            ])->where('id', '=', Session::get('user')->id)->execute();
            return $this->response('Vacation created');
        }

        return $this->response('Invalid date for vacation (date for vacation can not be previously added by user and must have available vacation days.)', 400);
    }


    protected function getVacationEndDate(DateTime $start_date, $duration): string
    {
        $holidays = $this->db->select()->from('holidays')->where('date', 'LIKE', "{$start_date->format('Y')}%")->get()->toArray();
        for ($i = 1; $i < $duration; $i++) {
            if ($start_date->format('N') >= 6 || $this->isDayHoliday($start_date, $holidays)) {
                $start_date->add(new \DateInterval('P1D'));
                $duration++;
            } else {
                $start_date->add(new \DateInterval('P1D'));
            }
        }
        return $start_date->format(self::date_format);
    }


    protected function isDayHoliday(DateTime $day, array $holidays): bool
    {
        $data = array_filter($holidays, function ($holiday) use ($day) {
            return $day->format('Y-m-d') === $holiday->date;
        });
        return (bool)$data;
    }

    protected function checkVacationByDate(DateTime $start_date): bool
    {
        $present_user_vacation = $this->db->select()->from('user_vacations')->where('user_id', '=', Session::get('user')->id)
            ->andWhere('start', '<=', $start_date->format(self::date_format))
            ->andWhere('end', '>=', $start_date->format(self::date_format))
            ->get();

        if ($present_user_vacation) {
            return true;
        }
        return false;
    }
}