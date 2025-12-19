<?php
namespace App\Core;

class Router
{
    private array $routes = [];

    public function get(string $path, callable|array $handler)
    {
        $this->map('GET', $path, $handler);
    }

    public function post(string $path, callable|array $handler)
    {
        $this->map('POST', $path, $handler);
    }

    private function map(string $method, string $path, callable|array $handler)
    {
        $this->routes[] = compact('method', 'path', 'handler');
    }

    public function dispatch()
    {
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $base = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/');
        error_log("REQUEST_URI: $uri");
        error_log("SCRIPT_NAME: " . $_SERVER['SCRIPT_NAME']);
        error_log("BASE: $base");
        if ($base && $base !== '/' && str_starts_with($uri, $base)) {
            $uri = substr($uri, strlen($base));
        }
        error_log("FINAL URI: $uri");
        $method = $_SERVER['REQUEST_METHOD'] ?? 'GET';

        foreach ($this->routes as $route) {
            if ($route['method'] === $method && $route['path'] === $uri) {
                return $this->invoke($route['handler']);
            }
        }

        http_response_code(404);
        echo '404 Not Found';
    }

    private function invoke(callable|array $handler)
    {
        if (is_array($handler)) {
            [$class, $method] = $handler;
            $instance = new $class();
            return call_user_func([$instance, $method]);
        }
        return call_user_func($handler);
    }
}
