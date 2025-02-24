<?php

if ($_SERVER['SERVER_NAME'] == 'localhost') {

    /** DATABSE CONFIG CONSTANTS */
    define('DBHOST', 'localhost');
    define('DBNAME', 'resume_generator');
    define('DBUSER', 'root');
    define('DBPASS', '');

    define('ROOT', 'http://localhost/php-resume-generator/public');
} else {
    define('DBHOST', 'localhost');
    define('DBNAME', 'resume-generator');
    define('DBUSER', 'root');
    define('DBPASS', '');

    define('ROOT', 'https://www.php-resume-generator.com');
}

define('APP_NAME', 'My Website');
define('APP_DESC', 'Resume Generator');

define('DEBUG', false);

// $test = "Hello";