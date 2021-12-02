<?php

namespace App\Core\Database;

use PDO;

class DBConnection
{
    /**
     * @var PDO|null
     */
    private static $instance = NULL;

    private function __construct()
    {
        self::$instance = new PDO(
            "mysql:dbname={$_ENV['DB_NAME']};host={$_ENV['DB_HOST']}",
            "{$_ENV['DB_USER']}",
            "{$_ENV['DB_PASSWORD']}",
            [PDO::ERRMODE_EXCEPTION ]
        );
    }

    static function getInstance(): ?PDO
    {
        if (is_null(self::$instance)) {
            new DBConnection();
        }
        return self::$instance;
    }
}