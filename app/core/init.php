<?php

spl_autoload_register(function ($classname) {
    $modelFilename = "../app/models/" . ucfirst($classname) . ".php";
    $controllerFilename = "../app/controllers/" . ucfirst($classname) . "Controller.php";

    if (file_exists($modelFilename)) {
        require $modelFilename;
    } elseif (file_exists($controllerFilename)) {
        require $controllerFilename;
    }
});

require 'config.php';
require 'functions.php';
require 'Database.php';
require 'Model.php';
require 'Controller.php';
require 'App.php';
require 'ResumeValidator.php';
