<?php

namespace App\Core\Request;

use stdClass;

class Request extends Validator
{
    protected stdClass $GET_PARAMS;

    protected stdClass $POST_PARAMS;

    protected stdClass $stdClass;

    public function __construct()
    {
        parent::__construct();
        $this->stdClass = new stdClass();
        $this->setGetParams();
        $this->setPostParams();
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
        if (!$_GET) return;
        foreach ($_GET as $key => $value) {
            $this->stdClass->{$key} = htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
        }
        $this->GET_PARAMS = $this->stdClass;
    }

    protected function setPostParams()
    {
        if (!$_POST) return;
        foreach ($_POST as $key => $value) {
            $this->stdClass->{$key} = htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
        }
        $this->POST_PARAMS = $this->stdClass;

    }

    public function getParams()
    {
        return $this->GET_PARAMS ?? $this->POST_PARAMS;
    }

}