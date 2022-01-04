<?php

namespace App\Core\View;

use Jenssegers\Blade\Blade;

class View
{
    /**
     * @var Blade
     */
    public $blade;

    public function __construct()
    {
        $this->blade = new Blade('./resources/views', 'cache');
    }

    public function render($name, array $data = [])
    {
        return $this->blade->render($name, $data);
    }
}