<?php

namespace App\Controllers;

use App\{Core\Authentication\Authentication, Core\Helpers\Redirect, Core\Session\Session};


class AuthenticationController extends Controller
{
    use Authentication;

    public function index()
    {
        return $this->view->renderView('auth.login', ['session' => Session::class]); //
    }

    public function registerForm()
    {
        //Check if user exists in session
        if (Session::get('user')) Redirect::to('/');
        return $this->view->renderView('auth.register');
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
        if ($this->authenticate($this->request)) {
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
            'email' => 'required|email|exists:users',
            'password' => 'required|min:8|regex:^\S*(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])\S*$^',
            'name' => 'required|min:3|max:10',
            'last_name' => 'required|min:3|max:10'
        ]);

        if (!$validation->isValid()) {
            Session::flash('errors', $validation->getMessages());
        } elseif ($this->performRegistration($this->request)) {
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