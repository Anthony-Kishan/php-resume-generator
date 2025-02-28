<?php
// app/core/Route.php

// namespace App\Core;

// class Route
// {
//     private static $routes = [];

//     // Add a route to the routing table
//     public static function add($url, $controller, $method = 'index')
//     {
//         self::$routes[] = [
//             'url' => $url,
//             'controller' => $controller,
//             'method' => $method
//         ];
//     }

//     // Match the current URL to one of the routes
//     public static function match($url)
//     {
//         foreach (self::$routes as $route) {
//             if ($route['url'] == $url) {
//                 return $route;
//             }
//         }
//         return null;
//     }

//     // Handle the request and route it to the proper controller and method
//     public static function handle($url)
//     {
//         $route = self::match($url);
//         if ($route) {
//             $controller = $route['controller'];
//             $method = $route['method'];
//             $controllerObj = new $controller();
//             call_user_func([$controllerObj, $method]);
//         } else {
//             // If no route matches, show a 404 page
//             echo "404 Not Found!";
//         }
//     }
// }









// app/core/Route.php

namespace App\Core;

class Route
{
    private static $routes = [];
    private static $controller = 'HomeController';
    private static $method = 'index';
    private static $param = [];

    // Add a route to the routing table
    public static function add($url, $controller, $method = 'index')
    {
        self::$routes[] = [
            'url' => $url,
            'controller' => $controller,
            'method' => $method
        ];
    }

    // Match the current URL to one of the routes
    public static function match($url)
    {
        foreach (self::$routes as $route) {
            if ($route['url'] == $url) {
                return $route;
            }
        }
        return null;
    }

    // Split the URL into segments
    private static function splitURL()
    {
        $URL = $_GET['url'] ?? 'home';
        return explode("/", trim($URL, "/"));
    }

    // Load and instantiate the controller dynamically
    private static function loadController()
    {
        $URL = self::splitURL();
        $controllerName = ucfirst($URL[0]) . "Controller";

        // Define possible controller paths
        $frontendControllerClass = "App\\Controllers\\Frontend\\$controllerName";
        $frontendControllerClass1 = "App\\Controllers\\Frontend\\user\\$controllerName";

        $backendControllerClass = "App\\Controllers\\Backend\\$controllerName";
        $backendControllerClass1 = "App\\Controllers\\Backend\\user\\$controllerName";

        // Check if the controller exists in the Frontend or Backend namespaces dynamically
        if (class_exists($frontendControllerClass) || class_exists($frontendControllerClass1)) {
            if (class_exists($frontendControllerClass1)) {
                self::$controller = $frontendControllerClass1;
            } else {
                self::$controller = $frontendControllerClass;
            }
        } elseif (class_exists($backendControllerClass) || class_exists($backendControllerClass1)) {
            if (class_exists($backendControllerClass1)) {
                self::$controller = $backendControllerClass1;
            } else {
                self::$controller = $backendControllerClass;
            }
        } else {
            self::$controller = "App\\Controllers\\Frontend\\_404";
        }

        $controller = new self::$controller;

        show($controller);

        // Select the method
        if (!empty($URL[1]) && method_exists($controller, $URL[1])) {
            self::$method = $URL[1];
            unset($URL[1]);
        }

        self::$param = $URL;

        // Call the method on the controller with the parameters
        call_user_func_array([$controller, self::$method], self::$param);
    }

    // Handle the request and route it to the proper controller and method
    public static function handle($url)
    {
        $route = self::match($url);

        if ($route) {
            self::loadController();
        } else {
            echo "404 Not Found!";
        }
    }
}
