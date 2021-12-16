<?php

namespace App\Core\Helpers;

use App\Core\Exceptions\ResponseErrorException;

class Redirect
{
    public static function to(string $path)
    {
        header("Location:$path");
        exit();
    }
}