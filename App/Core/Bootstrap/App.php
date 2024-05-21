<?php

namespace App\Core\Bootstrap;

use DI\{Container, ContainerBuilder};

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