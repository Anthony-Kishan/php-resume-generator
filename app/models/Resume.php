<?php
require_once "app/core/Database.php";

class Resume
{
    private $db;
    private $data;

    public function __construct()
    {
        $this->db = Database::getConnection();
    }

    public function setData($data)
    {
        $this->data = $data;
    }

    public function save()
    {
        $query = "INSERT INTO resumes (name, email, skills) VALUES (?, ?, ?)";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$this->data['name'], $this->data['email'], $this->data['skills']]);
    }
}
?>