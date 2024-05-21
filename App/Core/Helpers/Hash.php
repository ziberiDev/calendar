<?php

namespace App\Core\Helpers;

class Hash
{
    public static function make(string $value): bool|string
    {
        return hash('sha512', $value);
    }
}