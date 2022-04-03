<?php

namespace App\Helper;

class View
{
    public static ?View $instance = null;

    private function __construct()
    {
    }

    public static function getInstance(): View
    {
        if (!self::$instance instanceof View) {
            self::$instance = new View();
        }

        return self::$instance;
    }

    public static function render(string $view_path, array $data = []): void
    {
        $base_view_path = Config::get('view.base_view_path');

        $view_path = $base_view_path . $view_path . '.php';

        if (!file_exists($view_path)) {
            self::render('/404');
            return;
        }

        ob_start();

        if (!empty($data)) {
            extract($data);
        }

        include $view_path;

        echo (string) ob_get_clean();
    }
}
