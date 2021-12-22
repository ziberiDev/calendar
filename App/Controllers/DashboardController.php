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
    public function __construct(protected CalendarService $calendar, View $view, Request $request, QueryBuilder $db, Response $response)
    {
        /*       if (!Session::get('user')) Redirect::to('login');*/
        parent::__construct($view, $db, $request, $response);
    }


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

        return $this->response(json_encode($users) , 200 , ['Content-type' => 'application/json; charset=utf-8']);
    }

    public function index()
    {
        return $this->view->renderView('dashboard.index');
    }

    public function update()
    {
        $validation = $this->request->validate([
            'id' => 'required|exists:events'
        ]);
    }

}