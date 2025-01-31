<?php
// define('DB_HOST', 'localhost');
// define('DB_USER', 'root');
// define('DB_PASS', '');
// define('DB_NAME', 'resume_generator');

$conn = new mysqli('localhost', 'root', '', 'resume_generator');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>