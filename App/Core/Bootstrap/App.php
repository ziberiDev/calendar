<?php

namespace App\Core\Bootstrap;

use App\Core\Request\Request;
use App\Core\Router\Router;
use App\Core\Session\Session;
use DI\Container;
use DI\ContainerBuilder;
use Dotenv\Dotenv;
use function DI\create;
use function DI\get;

class App extends ContainerBuilder
{

    private Container $container;


    protected function buildContainer()
    {
        $this->addDefinitions('./definitions.php');
        $this->useAutowiring(true);
        $this->container = $this->build();
    }

    /**
     * @throws \Exception
     */
    public function get(string $string)
    {
        $this->buildContainer();
        try {
            return $this->container->get($string);

        } catch (\Throwable $e) {
            throw new \Exception("{$e->getMessage()}");
        }
    }
}