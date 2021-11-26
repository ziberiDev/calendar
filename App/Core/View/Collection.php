<?php

namespace App\Core\View;

use Iterator;

class Collection implements Iterator
{

    public function __construct(public array $items){}

    public function current()
    {
        return current($this->items);
    }

    public function next()
    {
        return next($this->items);
    }

    public function key()
    {
        return key($this->items);
    }

    public function valid(): bool
    {
        return current($this->items) !== false;
    }

    public function rewind()
    {
        return reset($this->items);
    }
}