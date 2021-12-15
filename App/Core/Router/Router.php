<?php

namespace App\Core\Router;


use App\Controllers\Controller;
use App\Core\Bootstrap\Facade\App;
use App\Core\Database\QueryBuilder;
use App\Core\Request\Request;
use App\Core\View\View;
use DI\Container;
use DI\ContainerBuilder;
use Exception;
use function DI\get;

class Router
{
    protected Container $container;

    /**
     * @var array routes array
     */
    protected array $routes = [
        "GET" => [],
        "POST" => []
    ];

    /**
     * @return Router
     * @throws Exception
     */
    public static function load(): Router
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
        $controller = App::get($controller);

        if (!method_exists($controller, $action)) {
            throw new Exception("$controller does not respond to the $action action");
        }
        echo $controller->$action();
        die();
    }
}