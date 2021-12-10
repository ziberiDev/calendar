<?php

namespace App\Core\View;

use Iterator;

class Collection implements Iterator
{

    public function __construct(public array $items)
    {
    }

    public function current(): mixed
    {
        return current($this->items);
    }

    public function next(): void
    {
        next($this->items);
    }

    public function key(): mixed
    {
        return key($this->items);
    }

    public function valid(): bool
    {
        return current($this->items) !== false;
    }

    public function rewind(): void
    {
        reset($this->items);
    }

    public function toArray(?int $key)
    {
        return isset($key) ? $this->items[$key] : $this->items;
    }
}