<?php

namespace App\Core\Router;


use App\Controllers\Controller;
use App\Core\Bootstrap\Facade\App;
use App\Core\Database\QueryBuilder;
use App\Core\Exceptions\ControllerUndefinedMethodException;
use App\Core\Exceptions\ResponseErrorException;
use App\Core\Exceptions\RouteNotDefinedException;
use App\Core\Request\Request;
use App\Core\Session\Session;
use App\Core\View\View;
use App\Middleware\MiddlewareServiceProvider;
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

    public function post($uri, array $controller, ?array $middleware = [])
    {
        if (!key_exists($uri, $this->routes['POST'])) {
            $this->routes['POST'][$uri] = array_merge($controller, $middleware);
        }
    }

    public function get($uri, array $controller, ?array $middleware = [])
    {
        if (!key_exists($uri, $this->routes['GET'])) {
            $this->routes['GET'][$uri] = array_merge($controller, $middleware);
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
            throw new RouteNotDefinedException("$requestType request is not supported for route $uri");
        }

        return $this->callAction(...$this->routes[$requestType][$uri]);
    }

    /**
     * @param $controller
     * @param $action
     * @param ...$middleware
     * @return mixed
     * @throws ControllerUndefinedMethodException
     */
    protected function callAction($controller, $action, ...$middleware): mixed
    {
        /*var_dump($controller , $action , $middleware);*/
        new MiddlewareServiceProvider($middleware);


        $controller = App::get($controller);


        if (!method_exists($controller, $action)) {
            return throw new ControllerUndefinedMethodException(get_class($controller) . "does not respond to the $action action");
        }

        echo $controller->$action();
        die();
    }
}