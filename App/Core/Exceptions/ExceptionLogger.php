<?php

namespace App\Core\Exceptions;

class ExceptionLogger
{
    protected string $time_of_log;
    protected string $logFile = "./storage/error.log";

    public function __construct()
    {
        $this->time_of_log = date('r');
    }

    public static function log()
    {

    }


}