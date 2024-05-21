<?php

namespace App\Controllers;

use App\Core\Helpers\Hash;
use App\Core\Helpers\Redirect;
use App\Core\Session\Session;

class UsersController extends Controller
{
    public function index()
    {
        $users = $this->db->select('*')->from('users')->where('id', '!=', Session::get('user')->id)->get();

        return $this->response(json_encode($users));
    }

    public function create()
    {
        $roles = $this->db->select('*')->from('roles')->get();


        return $this->view->render('dashboard.createUser', ['roles' => $roles]);
    }

    public function store()
    {

        $validation = $this->request->validate([
            'email' => 'required|email|not_in:users',
            'password' => 'required|min:8|regex:^\S*(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])\S*$^',
            'first_name' => 'required|min:3|max:10',
            'last_name' => 'required|min:3|max:10',
            'role' => 'required|exists:roles,id'
        ]);
        if (!$validation->isValid()) {
            return $this->response(json_encode($validation->getMessages()), 400);
        }
        $params = $this->request->getParams();
        $user = $this->db->insert('users', [
            'name' => $params->first_name,
            'last_name' => $params->last_name,
            'email' => $params->email,
            'password' => Hash::make($params->password),
            'role_id' => $params->role
        ])->execute();

        if ($user) {
            return $this->response('User created');
        }

    }

}