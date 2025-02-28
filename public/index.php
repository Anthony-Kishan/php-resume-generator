<?php


# index.php
session_start();

require "../app/core/init.php";
// require "../app/core/App.php";
require_once "../vendor/autoload.php";
require "../app/core/web.php";

DEBUG ? ini_set('display_errors', 1) : ini_set('display_errors', 0);

// $app = new App\Core\App;
// $app->loadController();

// $NavBarController = new NavBarController();
// $NavBarController->index();


