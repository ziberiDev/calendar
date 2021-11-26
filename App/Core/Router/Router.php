<?php

namespace App\Core\Router;


use Exception;

class Router
{
    /**
     * @var array routes array
     */
    protected array $routes = [
        "GET" => [],
        "POST" => []
    ];

    /**
     * @return Router
     */
    public static function loadWebRoutes(): Router
    {
        $router = new self;
        require_once "./resources/routes/web.php";
        return $router;
    }

    public function post($uri, array $controller)
    {
        if (!key_exists($uri, $this->routes['POST'])) {
            $this->routes['POST'][$uri] = $controller;
        }
    }

    public function get($uri, array $controller)
    {
        if (!key_exists($uri, $this->routes['GET'])) {
            $this->routes['GET'][$uri] = $controller;
        }
    }

    /**
     * @param $uri
     * @param $requestType
     * @return mixed
     * @throws Exception
     */
    public function direct($uri, $requestType): mixed
    {
        if (!array_key_exists($uri, $this->routes[$requestType])) {
            throw new Exception("route is not defined");
        }
        return $this->callAction(...$this->routes[$requestType][$uri]);
    }

    /**
     * @param $controller
     * @param $action
     * @return mixed
     * @throws Exception
     */
    protected function callAction($controller, $action): mixed
    {
        $controller = new $controller();
        if (!method_exists($controller, $action)) {
            throw new Exception("$controller does not respond to the $action action");
        }
        return $controller->$action();
    }
}