<?php
require_once 'config/config.php';
require_once 'app/core/Router.php';

// Start the Router
$router = new Router();
$router->handleRequest();
?>
