<?php

namespace App\Helper;

class Config
{
    const BASE_CONFIG_PATH = __DIR__ . '/../../config/';

    public static ?Config $instance = null;

    private function __construct()
    {
    }

    public static function getInstance(): Config
    {
        if (!self::$instance instanceof Config) {
            self::$instance = new Config();
        }

        return self::$instance;
    }

    public static function get(string $config_path): string|callable|array|null
    {
        $config_file = explode('.', $config_path)[0];

        if (!$config_array = @require(self::BASE_CONFIG_PATH . $config_file . '.php')) {
            return null;
        }

        $config_constant_array = array_slice(explode('.', $config_path), 1);

        return static::resolveConstants($config_array, $config_constant_array);
    }

    private static function resolveConstants(array $config_array, array $config_constant_array): string|callable|array|null
    {
        $constant = $config_array;

        foreach ($config_constant_array as $config_constant) {
            $constant = static::resolveConstant($constant, $config_constant);

            if (is_null($constant)) {
                break;
            }
        }

        return $constant;
    }

    private static function resolveConstant(array|string $config_array, string $config_constant): array|string|callable|null
    {
        if (is_string($config_array)) {
            return null;
        }

        return $config_array[$config_constant] ?? null;
    }
}
