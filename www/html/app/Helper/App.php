<?php

namespace App\Helper;

require __DIR__ . "/../../routes/index.php";

use App\Helper\Router;
use App\Helper\View;
use Dotenv\Dotenv;

class App
{
    public static function run(): void
    {
        $dotenv = Dotenv::createImmutable(__DIR__ . '/../../..');
        $dotenv->safeLoad();

        $router = Router::getInstance();

        try {
            $request_uri = $_SERVER['REQUEST_URI'];
            $request_method = strtolower($_SERVER['REQUEST_METHOD']);

            $router->resolve($request_method, $request_uri);
        } catch (\Exception $e) {
            http_response_code(404);
            View::render('404');
        }
    }
}
