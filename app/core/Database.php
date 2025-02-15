<?php
class Database
{
    private static $instance = null;
    private $connection;

    private $host = "localhost";
    private $user = "root";
    private $password = "";
    private $database = "resume-generator";

    private function __construct()
    {
        $this->connection = new mysqli($this->host, $this->user, $this->password, $this->database);

        if ($this->connection->connect_error) {
            die("Database connection failed: " . $this->connection->connect_error);
        }
    }

    public static function getConnection()
    {
        if (self::$instance == null) {
            self::$instance = new Database();
        }
        return self::$instance->connection;
    }
}
?>