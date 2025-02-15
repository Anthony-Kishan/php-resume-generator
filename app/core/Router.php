<?php
class Router
{
    public function handleRequest()
    {
        $url = isset($_GET['url']) ? $_GET['url'] : 'resume';
        $url = explode("/", filter_var(trim($url, "/"), FILTER_SANITIZE_URL));

        $controllerName = ucfirst($url[0]) . "Controller";
        $method = isset($url[1]) ? $url[1] : 'create';

        $controllerPath = "app/controllers/" . $controllerName . ".php";

        if (file_exists($controllerPath)) {
            require_once $controllerPath;
            $controller = new $controllerName();

            if (method_exists($controller, $method)) {
                $controller->$method();
            } else {
                var_dump($controller);
                echo "Method not found.";
            }
        } else {
            echo $controllerPath;
            echo "Controller not found.";
        }
    }
}
?>