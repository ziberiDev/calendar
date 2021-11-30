<?php

namespace App\Core\Request;

class Request extends Validator
{
    protected $GET_PARAMS = [];

    protected $POST_PARAMS = [];

    public function __construct()
    {
        $this->setGetParams();
        $this->setGetParams();
    }

    /**
     * @return string
     */
    public static function uri(): string
    {
        return trim(
            parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), "/"
        );
    }

    /**
     * @return mixed
     */
    public static function method(): mixed
    {
        return $_SERVER['REQUEST_METHOD'];
    }

    protected function setGetParams()
    {
        foreach ($_GET as $key => $value) {
            $this->GET_PARAMS[$key] = htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
        }
    }

    protected function setPostParams()
    {
        foreach ($_POST as $key => $value) {
            $this->POST_PARAMS[$key] = htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
        }
    }

    public function getParams()
    {
        return $this->GET_PARAMS ?? $this->POST_PARAMS;
    }

}