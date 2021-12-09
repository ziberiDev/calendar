<?php

namespace App\Core\Authentication;

use App\Core\Database\QueryBuilder;
use App\Core\Helpers\Hash;
use App\Core\Request\Request;
use App\Core\Session\Session;
use App\Core\View\Collection;
use stdClass;

trait Authentication
{
    use QueryBuilder;

    public function __AuthenticationConstruct()
    {
        $this->__QueryBuilderConstruct();
    }

    public function authenticate(Request $request)
    {
        $params = $request->getParams();

        if ($user = $this->try($params->email, $params->password)) {
            Session::set('user', $user);
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
            return $user->toArray(0);
        }
        return false;
    }

    private function performRegistration(Request $request)
    {
        $params = $request->getParams();

        $user = $this->insert('users', [
            'name' => $params->name,
            'last_name' => $params->last_name,
            'email' => $params->email,
            'password' => Hash::make($params->password)
        ]);

        if ($user) {
            Session::set('user', $request->getParams());
            return true;
        }
        return false;
    }
}