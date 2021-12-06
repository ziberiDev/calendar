<?php

namespace App\Core\Session;

class Session
{
    protected static $flushed;

    public function start(array $options = [])
    {
        return session_start($options);
    }

    public function set($key, $value)
    {
        //TODO: setters for object or an araay.
        $_SESSION[$key] = $value;
        $_SESSION[$key]['flush'] = false;

    }

    public static function get(string $key)
    {
        //TODO: getters for object or an araay.
        if (isset($_SESSION[$key]) && $_SESSION[$key]['flush']) {
            self::$flushed = $_SESSION[$key];
            unset($_SESSION[$key]);
        };
        return $_SESSION[$key] ?? self::$flushed ?? null;
    }

    public static function flush($key, $value)
    {
        $_SESSION[$key] = $value;
        $_SESSION[$key]['flush'] = true;
    }

}