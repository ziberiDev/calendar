<?php

namespace App\Core\Enums;

enum Role: int
{
    case Employee = 1;
    case Admin = 2;
    case Manager = 3;

    public function canUpdate()
    {
        return match ($this) {
            self::Employee => false,
            self::Admin, self::Manager => true
        };
    }

    public function canCreateUser()
    {
        return match ($this) {
            self::Employee, self::Manager => false,
            self::Admin => true
        };
    }

}