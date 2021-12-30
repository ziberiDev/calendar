<?php

namespace App\Controllers;

use App\{Core\CalendarService,
    Core\Database\QueryBuilder,
    Core\Helpers\Hash,
    Core\Helpers\Redirect,
    Core\Request\Request,
    Core\Response\Response,
    Core\Session\Session,
    Core\View\View
};
use Faker\Factory as Faker;


class DashboardController extends Controller
{


    public function test()
    {
        $faker = Faker::create();
        $data = [];
        for ($i = 0; $i < 3; $i++) {
            $data[] = [
                'name' => $faker->firstName(),
                'last_name' => $faker->lastName(),
                'email' => $faker->email,
                'password' => Hash::make($faker->word())
            ];
        }

        $users = $this->db->insert('users', $data)->execute();
        /*  ini_set('default_mimetype', 'application/json');*/ // need to improve this in the response

        return $this->response(json_encode($users));
    }

    public function index()
    {
        return $this->view->render('dashboard.index');
    }
}