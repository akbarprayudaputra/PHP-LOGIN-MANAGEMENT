<?php

namespace Akbarprayuda\PhpMvc\Config;

class Router
{
    private static $routes = [];

    public static function add(string $method, string $path, string $controller, string $function, array $middlewares = []): void
    {
        self::$routes[] = [
            "method" => $method,
            "path" => $path,
            "controller" => $controller,
            "function" => $function,
            "middlewares" => $middlewares,
        ];
    }

    public static function run(): void
    {
        $path = '/';
        // var_dump(self::$routes);

        if (isset($_SERVER["PATH_INFO"])) $path = $_SERVER["PATH_INFO"];

        $method = $_SERVER["REQUEST_METHOD"];

        foreach (self::$routes as $value) {
            $pattern = "#^" . $value["path"] . "$#";

            if (preg_match($pattern, $path, $variables) && $method == $value["method"]) {
                foreach ($value["middlewares"] as $middleware) {
                    $instance = new $middleware;
                    $instance->before();
                }

                $controller = new $value["controller"];
                $function = $value["function"];

                array_shift($variables);

                call_user_func_array([$controller, $function], $variables);

                return;
            }
        }

        http_response_code(404);
        echo "<h1>404 Not Found</h1>" . PHP_EOL;
    }
}
