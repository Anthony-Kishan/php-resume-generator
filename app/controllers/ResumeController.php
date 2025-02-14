<?php
require_once "app/models/Resume.php";

class ResumeController
{
    public function create()
    {
        require "app/views/resume/create.php";
    }

    public function preview()
    {
        require "app/views/resume/preview.php";
    }

    public function save()
    {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $resume = new Resume();
            $resume->setData($_POST);
            $resume->save();
            header("Location: /resume/preview");
        }
    }
}
?>