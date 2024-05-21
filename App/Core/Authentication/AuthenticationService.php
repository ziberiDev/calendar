<?php

namespace App\Core\Authentication;

use App\Core\{Database\QueryBuilder, Helpers\Hash, Request\Request, Session\Session};
use League\OAuth2\Client\Provider\Exception\FacebookProviderException;
use League\OAuth2\Client\Provider\Facebook;
use stdClass;

class AuthenticationService
{

    public \League\OAuth2\Client\Provider\Facebook $facebookProvider;

    public function __construct(protected QueryBuilder $db)
    {
//TODO: set keys for facebook app in env file
        $this->facebookProvider = new Facebook([
            'clientId' => '1068337310654180',
            'clientSecret' => '20d1dc1f1fbad41e3feb88aa47958a4d',
            'redirectUri' => 'https://5884-89-205-96-37.ngrok.io/loginwithfacebook',
            'graphApiVersion' => 'v12.0',
        ]);

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

    protected function try(string $email, string $password): stdClass|null
    {
        $password = Hash::make($password);
        $user = $this->db->select('id,name,last_name,email,role_id,vacation_days')->from('users')
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
        /**
         * var Collection $user
         */
        $user = $this->db->insert('users', [
            'name' => $params->name,
            'last_name' => $params->last_name,
            'email' => $params->email,
            'password' => Hash::make($params->password)
        ])->execute();

        if ($user) {
            Session::set('user', $user->toArray(0));
            return true;
        }
        return false;
    }

    /**
     * @return string
     */
    public function getFaceAuthUri()
    {
        return $this->facebookProvider->getAuthorizationUrl(['scope' => ['public_profile', 'email']]);
    }

    public function authenticateWithFacebook(string $code)
    {

        $token = $this->facebookProvider->getAccessToken('authorization_code', [
            'code' => $code
        ]);
        $faceBookUserEmail = $this->facebookProvider->getResourceOwner($token)->getEmail();

        $user = $this->db->select('id,name,last_name,email,role_id,vacation_days')->from('users')
            ->where('email', '=', $faceBookUserEmail)
            ->get();
        if ($user) {
            Session::set('user', $user->toArray(0));
            return true;
        }
        return false;
    }
}