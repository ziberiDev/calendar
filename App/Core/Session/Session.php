<?php

namespace App\Core\Session;

class Session
{
    public  function start(array $options = [])
    {
        return session_start($options);
    }

    public  function set($key, $value)
    {
        $_SESSION[$key] = $value;
    }

    public static function get(string $key)
    {
        return $_SESSION[$key];
    }

}