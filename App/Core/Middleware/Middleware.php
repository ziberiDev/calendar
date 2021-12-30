<?php

namespace App\Core\Middleware;

use App\Core\Database\QueryBuilder;
use App\Core\Request\Request;
use App\Core\Response\Response;

class Middleware
{
    public function __construct(protected Request $request, protected Response $response ,protected QueryBuilder $db){}

    public function response(string $content, ?int $code = 200, ?array $headers = [])
    {
        return $this->response
            ->create($content, $code, $headers)
            ->send();
    }
}