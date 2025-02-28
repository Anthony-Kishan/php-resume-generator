<?php
# app/core/App.php

namespace App\Core;

class App
{
    private $controller = 'HomeController';
    private $method = 'index';

    private function splitURL()
    {
        $URL = $_GET['url'] ?? 'home';
        return explode("/", trim($URL, "/"));
    }

    /** * Loads Controllers and their Methods */
    public function loadController()
    {
        $URL = $this->splitURL();
        $controllerName = ucfirst($URL[0]) . "Controller";

        // Define paths for Frontend & Backend controllers
        $frontendPath = "../app/controllers/Frontend/{$controllerName}.php";
        $backendPath = "../app/controllers/Backend/{$controllerName}.php";

        // Check if the controller exists in Frontend or Backend
        if (file_exists($frontendPath)) {
            require_once $frontendPath;
            $this->controller = "App\\Controllers\\Frontend\\$controllerName"; // Use the correct namespace
        } elseif (file_exists($backendPath)) {
            require_once $backendPath;
            $this->controller = "App\\Controllers\\Backend\\$controllerName"; // Use the correct namespace
        } else {
            require "../app/controllers/_404.php";
            $this->controller = "App\\Controllers\\_404"; // Use the correct namespace
        }

        $controller = new $this->controller;

        /** SELECT METHOD */
        if (!empty($URL[1]) && method_exists($controller, $URL[1])) {
            $this->method = $URL[1];
            unset($URL[1]);
        }

        call_user_func_array([$controller, $this->method], $URL);
    }
}





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



