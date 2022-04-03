<?php

namespace App\Helper;

class DB
{
    public static ?DB $instance = null;

    private function __construct(public array $config)
    {
    }

    public static function getInstance(array $config): DB
    {
        if (is_null(self::$instance)) {
            self::$instance = new DB($config);
        }

        return self::$instance;
    }
}
