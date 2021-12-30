<?php

namespace App\Controllers;

use App\Core\Session\Session;

class UsersController extends Controller
{
    public function index()
    {
        $users = $this->db->select('*')->from('users')->where('id', '!=', Session::get('user')->id)->get();

        return $this->response(json_encode($users));
    }

}