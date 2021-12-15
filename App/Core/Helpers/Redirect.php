<?php

namespace App\Core\Helpers;

class Redirect
{
    public static function to(string $path)
    {
        header("Location:$path");
        exit();
    }
}