<?php

namespace App\Core\Session;

class Session
{
    protected static $flushed;

    public function start(array $options = [])
    {
        return session_start($options);
    }

    public static function set($key, $value)
    {
        $_SESSION[$key] = $value;
    }

    public static function get(string $key)
    {
        return $_SESSION[$key] ?? null;
    }

    public static function delete(string $key)
    {
        if (!isset($_SESSION[$key])) return false;
        unset($_SESSION[$key]);
        return true;
    }

    public static function getFlashed($key)
    {
        if (isset($_SESSION[$key]) && $_SESSION[$key]['flush']) {
            self::$flushed = $_SESSION[$key];
            unset($_SESSION[$key]);
        };
        return self::$flushed ?? null;
    }

    public static function flash($key, array $value)
    {
        $_SESSION[$key] = $value;
        $_SESSION[$key]['flush'] = true;
    }
}