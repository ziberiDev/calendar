<?php

namespace App\Core\View;

use Illuminate\Container\Container;
use Jenssegers\Blade\Blade;

class View
{
    /**
     * @var Blade
     */
    protected $blade;

    public function __construct()
    {
        $this->blade = new Blade('./resources/views', 'cache');

    }

    public function renderView($name, array $data = [])
    {
        echo $this->blade->render($name, $data);
    }
}