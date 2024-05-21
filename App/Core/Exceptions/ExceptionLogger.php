<?php

namespace App\Core\Exceptions;

class ExceptionLogger
{
    protected static string $logFile = "./storage/error.log";


    public static function log(string $message)
    {
        $time_of_log = date('r');
        $file = fopen(self::$logFile, 'a+');

        fwrite($file, PHP_EOL . $time_of_log . PHP_EOL);
        fwrite($file, $message . PHP_EOL);
        fclose($file);
    }


}