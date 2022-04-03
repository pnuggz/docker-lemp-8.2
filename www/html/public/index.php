<?php

require __DIR__ . "/../../vendor/autoload.php";
require __DIR__ . "/../routes/index.php";

use App\Helper\Router;
use App\Helper\View;

$router = Router::getInstance();

try {
    $request_uri = $_SERVER['REQUEST_URI'];
    $request_method = strtolower($_SERVER['REQUEST_METHOD']);

    $router->resolve($request_method, $request_uri);
} catch (\Exception $e) {
    http_response_code(404);
    View::render('404');
}
