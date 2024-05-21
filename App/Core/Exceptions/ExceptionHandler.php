<?php

namespace App\Core\Exceptions;

use Exception;

class ExceptionHandler
{
    protected string $exceptionName;

    protected array $loggable = [
        RouteNotDefinedException::class
    ];


    public function __construct(protected Exception $exception, protected ExceptionLogger $logger)
    {
        $this->exceptionName = get_class($exception);
    }

    public function handle()
    {

            $this->logger::log($this->exception);

        echo $this->exception->getMessage();
    }

    protected function inDevelopment()
    {
        if (getenv('DEVELOPMENT')) {
            return true;
        }
        return false;
    }


}