<?php

namespace App\Controllers;

use App\{Core\Authentication\AuthenticationService,
    Core\CalendarService,
    Core\Database\QueryBuilder,
    Core\Helpers\Redirect,
    Core\Request\Request,
    Core\Response\Response,
    Core\Session\Session,
    Core\View\View
};


class AuthenticationController extends Controller
{

    public function __construct(protected AuthenticationService $authentication, View $view, Request $request, QueryBuilder $db, Response $response)
    {
        parent::__construct($view, $db, $request, $response);
    }

    public function index()
    {
        return $this->view->render('auth.login', ['session' => Session::class, 'authFacebookUri' => $this->authentication->getFaceAuthUri()]); //
    }

    public function registerForm()
    {
        //Check if user exists in session
        if (Session::get('user')) Redirect::to('/');
        return $this->view->render('auth.register');
    }

    public function facebooklogin()
    {

        if ($code = $this->request->getParams()->code) {

            if ($this->authentication->authenticateWithFacebook($code)) {
                Redirect::to('/');
            };
            Session::flash('authError', ["No such user exist email doesn't match"]);
            Redirect::to('login');
        }
        Redirect::to('login');
    }

    public function login()
    {
        //Check if user exists in session
        if (Session::get('user')) Redirect::to('/');

        $validation = $this->request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);
        if (!$validation->isValid()) {
            Session::flash('errors', $validation->getMessages());
            Redirect::to("login");
        }
        if ($this->authentication->authenticate($this->request)) {
            Redirect::to('/');
        }
        Session::flash('authError', ['Credentials dont mach']);
        Redirect::to('login');
    }

    public function register()
    {
        //Check if user exists in session
        if (Session::get('user')) Redirect::to('/');
        $validation = $this->request->validate([
            'email' => 'required|email|not_in:users',
            'password' => 'required|min:8|regex:^\S*(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])\S*$^',
            'name' => 'required|min:3|max:10',
            'last_name' => 'required|min:3|max:10'
        ]);

        if (!$validation->isValid()) {
            Session::flash('errors', $validation->getMessages());
        } elseif ($this->authentication->performRegistration($this->request)) {
            Redirect::to('/');
        }
        Redirect::to('register');
    }

    public function logout()
    {
        //Check if user exists in session
        if (!Session::get('user')) Redirect::to('login');

        if (Session::delete('user'))
            Redirect::to('login');
        return false;
    }
}