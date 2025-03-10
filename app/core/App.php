<?php
# app/core/App.php

namespace App\Core;

class App
{
    private $controller = "HomeController";
    private $method = "index";
    private $params = [];

    public function __construct()
    {
        $url = $this->parseURL();

        // Check if the controller exists
        $controllerClass = $this->getControllerClass($url[0] ?? "home");

        if (class_exists($controllerClass)) {
            $this->controller = new $controllerClass;
            unset($url[0]);
        } else {
            $this->controller = new \App\Controllers\Frontend\_404;
        }

        // Check if method exists
        if (!empty($url[1]) && method_exists($this->controller, $url[1])) {
            $this->method = $url[1];
            unset($url[1]);
        }

        $this->params = array_values($url);
        call_user_func_array([$this->controller, $this->method], $this->params);
    }

    private function parseURL()
    {
        return explode("/", trim($_GET['url'] ?? "home", "/"));
    }

    private function getControllerClass($name)
    {
        $controllerName = ucfirst($name) . "Controller";
        $frontendClass = "App\\Controllers\\Frontend\\$controllerName";
        $backendClass = "App\\Controllers\\Backend\\$controllerName";

        return class_exists($frontendClass) ? $frontendClass : (class_exists($backendClass) ? $backendClass : null);
    }
}




// OLD
// class App
// {
//     private $controller = 'Home';
//     private $method = 'index';

//     private function splitURL()
//     {
//         $URL = $_GET['url'] ?? 'home';
//         $URL = explode("/", trim($URL, "/"));
//         return $URL;
//     }

//     /** * Loads Controllers and their Methods */
//     public function loadController()
//     {
//         $URL = $this->splitURL();

//         /** SELECT CONTROLLER */
//         $filename = "../app/controllers/" . ucfirst($URL[0]) . "Controller.php";

//         if (file_exists($filename)) {
//             require $filename;
//             $this->controller = ucfirst($URL[0]) . "Controller";
//             unset($URL[0]);
//         } else {
//             $filename = "../app/controllers/_404.php";
//             require $filename;
//             $this->controller = "_404";
//         }


//         $controller = new $this->controller;

//         /** SELECT METHOD */
//         if (!empty($URL[1])) {
//             if (method_exists($controller, $URL[1])) {
//                 $this->method = $URL[1];
//                 unset($URL[1]);
//             }
//         }

//         call_user_func_array([$controller, $this->method], $URL);
//     }
// }



