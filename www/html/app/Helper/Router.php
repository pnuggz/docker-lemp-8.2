<?php

namespace App\Helper;

use App\Exception\RouteNotFoundException;
use App\Http\Controller\BaseController;

class Router
{
    const ROUTE_METHOD_GET = 'get';
    const ROUTE_METHOD_POST = 'post';

    public static ?Router $instance = null;

    private array $routes_get = [];
    private array $routes_post = [];

    private function __construct()
    {
    }

    public static function getInstance(): Router
    {
        if (!self::$instance instanceof Router) {
            self::$instance = new Router();
        }

        return self::$instance;
    }

    public static function get(string $route, string $class, string $method): self
    {
        $router = static::getInstance();

        $router->routes_get[$route] = [
            'class' => $class,
            'method' => strtolower($method),
        ];

        return $router;
    }

    public static function post(string $route, string $class, string $method): self
    {
        $router = static::getInstance();

        $router->routes_post[$route] = [
            'class' => $class,
            'method' => strtolower($method),
        ];

        return $router;
    }

    public function resolve(string $request_method, string $request_uri)
    {
        $route = explode('?', $request_uri)[0];

        $action = null;
        $query_strings = [];

        if ($request_method === self::ROUTE_METHOD_GET) {
            $action = $this->routes_get[$route] ?? null;
            $query_strings = $_GET;
        } else if ($request_method === self::ROUTE_METHOD_POST) {
            $action = $this->routes_post[$route] ?? null;
            $query_strings = $_POST;
        }

        if (!$action) {
            throw new RouteNotFoundException();
        }

        if (is_callable($action)) {
            return call_user_func($action, $query_strings);
        }

        $class = new $action['class']($query_strings);
        $method = $action['method'];

        if ($class instanceof BaseController && method_exists($class, $method)) {
            return call_user_func_array([$class, $method], []);
        }

        throw new RouteNotFoundException();
    }
}
