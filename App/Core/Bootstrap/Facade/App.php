<?php

namespace App\Core\Bootstrap\Facade;


class App
{
    public static function get(string $string)
    {
        $app = new \App\Core\Bootstrap\App();
        try {
            return $app->get($string);

        } catch (\Exception $e) {
            throw new \Exception("{$e->getMessage()}");
        }
    }
}