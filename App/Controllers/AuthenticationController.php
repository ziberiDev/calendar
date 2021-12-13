<?php

namespace App\Controllers;

use App\Core\Authentication\Authentication;
use App\Core\Helpers\Redirect;
use App\Core\Request\Request;
use App\Core\Session\Session;


class AuthenticationController extends Controller
{
    use Authentication;

    public function __construct()
    {
        //Check if user exists in session
        if (Session::get('user')) Redirect::to('/');
        parent::__construct();
        $this->__AuthenticationConstruct();
    }

    public function index()
    {
        return $this->renderView('auth.login', ['session' => Session::class]);
    }

    public function registerForm()
    {

        return $this->renderView('auth.register');
    }


    public function login()
    {
        $request = new Request();
        $validation = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);
        if (!$validation->isValid()) {
            Session::flash('errors', $validation->getMessages());
            Redirect::to("login");
        }
        if ($this->authenticate($request)) {
            Redirect::to('/');
        }
        Session::flash('authError', ['Credentials dont mach']);
        Redirect::to('login');

    }

    public function register()
    {
        $request = new Request();

        $validation = $request->validate([
            'email' => 'required|email|exists:users',
            'password' => 'required|min:8|regex:^\S*(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])\S*$^',
            'name' => 'required|min:3|max:10',
            'last_name' => 'required|min:3|max:10'
        ]);
        if (!$validation->isValid()) {
            Session::flash('errors', $validation->getMessages());
        } elseif ($this->performRegistration($request)) {
            Redirect::to('/');
        }
        Redirect::to('register');
    }
}