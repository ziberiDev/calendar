<?php

namespace App\Core\Authentication;

use App\Core\Database\QueryBuilder;
use App\Core\Helpers\Hash;
use App\Core\Request\Request;
use App\Core\Session\Session;
use stdClass;

trait Authentication
{
    use QueryBuilder;

    protected Session $session;

    public function __AuthenticationConstruct()
    {
        $this->__QueryBuilderConstruct();
        $this->session = new Session();
    }

    public function authenticate(Request $request)
    {
        $params = $request->getParams();

        if ($user = $this->try($params->email, $params->password)) {
            $this->session->set('user', $user);
            return true;
        }
        return false;
    }

    protected function try(string $email, string $password): stdClass|bool
    {
        $password = Hash::make($password);
        $user = $this->select('id,name,last_name,email')->from('users')
            ->where('email', '=', $email)
            ->andWhere('password', '=', $password)
            ->get();
        if ($user) {
            return $user;
        }
        return false;
    }
}