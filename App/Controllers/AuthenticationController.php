<?php

namespace App\Controllers;

use App\Core\Request\Request;
use App\Core\Session\Session;
use Carbon\Carbon;


class AuthenticationController extends Controller
{
    public function index()
    {
        return $this->renderView('homepage.index');
    }

    public function login()
    {
        $request = new Request();

        $validation = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if ($this->authenticate($request)) {
            return $this->renderView('dashboard.index.com');
        }

        //TODO: implement redirect method figure out to pass error messages in session and delete them on print
        return $this->renderView('homepage.index', $validation->getMessages());
    }


}