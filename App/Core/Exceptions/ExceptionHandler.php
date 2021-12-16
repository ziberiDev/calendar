<?php

namespace App\Core\Exceptions;

use Exception;

class ExceptionHandler
{
    protected $exceptionName;


    public function __construct(protected Exception $exception)
    {
        $this->exceptionName = get_class($exception);
    }

    public function handle()
    {
        var_dump($this->exception->getTraceAsString());
    }

    protected function inDevelopment()
    {
        if (getenv('DEVELOPMENT')) {
            return true;
        }
        return false;
    }


}