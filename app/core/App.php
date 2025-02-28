<?php
# app/core/App.php

namespace App\Core;
use App\Controllers\Frontend\User\AuthController;
use App\Controllers\Frontend\HomeController;

// NEW
class App
{
    public function __construct()
    {
        Route::add('home', HomeController::class, 'index');
        Route::add('auth/logout', AuthController::class, 'logout');
        Route::add('auth/login', AuthController::class, 'login');
    }

    public function loadController()
    {
        $url = $_GET['url'] ?? 'home'; // Get the URL from the query string
        // show($url);
        Route::handle($url);  // Route the request
    }
}






// LATEST
class App
{
    private $controller = 'HomeController';
    private $method = 'index';
    private $param = [];

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

        // Check if the controller exists in the Frontend or Backend namespaces dynamically
        $frontendControllerClass = "App\\Controllers\\Frontend\\$controllerName";
        $frontendControllerClass1 = "App\\Controllers\\Frontend\\user\\$controllerName";

        $backendControllerClass = "App\\Controllers\\Backend\\$controllerName";
        $backendControllerClass1 = "App\\Controllers\\Backend\\user\\$controllerName";


        if (class_exists($frontendControllerClass) || class_exists($frontendControllerClass1)) {
            if (class_exists($frontendControllerClass1)) {
                $this->controller = $frontendControllerClass1;
            } else
                $this->controller = $frontendControllerClass;

        } elseif (class_exists($backendControllerClass) || class_exists($backendControllerClass1)) {
            if (class_exists($backendControllerClass1)) {
                $this->controller = $backendControllerClass1;
            } else
                $this->controller = $backendControllerClass;

        } else {
            $this->controller = "App\\Controllers\\Frontend\\_404";
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



