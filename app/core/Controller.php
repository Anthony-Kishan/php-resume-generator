<?php
# app/core/Controller.php

namespace App\Core;

class Controller
{
    public function view($name, $data = [])
    {
        if (!empty($data)) {
            extract($data);
        }

        $className = get_called_class();
        $namespaceParts = explode("\\", $className);

        $module = in_array("Backend", $namespaceParts) ? "Backend" : "Frontend";

        $filename = "../app/views/{$module}/" . $name . ".view.php";

        if (file_exists($filename)) {
            require $filename;
        } else {
            require "../app/views/404.view.php";
        }
    }
}


// class Controller
// {
//     public function view($name, $data = [])
//     {
//         if (!empty($data)) {
//             extract($data);
//         }

//         $filename = "../app/views/" . $name . ".view.php";

//         if (file_exists($filename)) {
//             require $filename;
//         } else {
//             $filename = "../app/views/404.view.php";
//             require $filename;
//         }
//     }
// }