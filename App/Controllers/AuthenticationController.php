<?php

namespace App\Controllers;

use App\Core\Request\Request;
use App\Core\Session\Session;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\MessageBag;


class AuthenticationController extends Controller
{
    public function index()
    {
        return $this->renderView('auth.login');
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

            Session::flush('errors', $validation->getMessages());
            header("location:/");
            die();
        }

        if ($this->authenticate($request)) {

            header("Location:dashboard");
            die();
        }

        Session::flush('authError', ['Credentials dont mach']);

        header("location:/");
        die();
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
        Session::flush('errors', $validation->getMessages());
        Session::flush('old', $request->getParams());
        return header('Location:register');


    }


}