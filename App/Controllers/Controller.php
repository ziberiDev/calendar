<?php

namespace App\Controllers;


use App\Core\Authentication\Authentication;
use App\Core\Database\QueryBuilder;
use App\Core\Request\Request;
use App\Core\Response\Response;
use App\Core\View\View;


class Controller
{
    public function __construct(
        protected View         $view,
        protected QueryBuilder $db,
        protected Request      $request,
        protected Response     $response
    )
    {
    }


    public function response(string $content, ?int $code = 200, ?array $headers = [])
    {
        return $this->response
            ->create($content, $code, $headers)
            ->send();
    }

}