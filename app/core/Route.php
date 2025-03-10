<?php
# app/core/Route.php

namespace App\Core;

class Route
{
    private static $routes = [];

    public static function add($url, $controller, $method = "index")
    {
        self::$routes[$url] = ["controller" => $controller, "method" => $method];
    }

    public static function handle($url)
    {
        if (isset(self::$routes[$url])) {
            $route = self::$routes[$url];
            $controller = new $route["controller"];
            call_user_func([$controller, $route["method"]]);
        } else {
            echo "404 Not Found!";
        }
    }
}