<?php

namespace App\Core\Authentication;

use App\Core\{Database\QueryBuilder, Helpers\Hash, Request\Request, Session\Session};
use stdClass;

class AuthenticationService
{

    public function __construct(protected QueryBuilder $db){}

    public function authenticate(Request $request)
    {
        $params = $request->getParams();

        if ($user = $this->try($params->email, $params->password)) {
            Session::set('user', $user);
            return true;
        }
        return false;
    }

    protected function try(string $email, string $password): stdClass|null
    {
        $password = Hash::make($password);
        $user = $this->db->select('id,name,last_name,email,role_id')->from('users')
            ->where('email', '=', $email)
            ->andWhere('password', '=', $password)
            ->get();

        if ($user) {
            return $user->toArray(0);
        }
        return null;
    }

    public function performRegistration(Request $request)
    {
        $params = $request->getParams();
        $user = $this->db->insert('users', [
            'name' => $params->name,
            'last_name' => $params->last_name,
            'email' => $params->email,
            'password' => Hash::make($params->password)
        ])->execute();

        if ($user) {
            Session::set('user', (object)$user[0]);
            return true;
        }
        return false;
    }
}