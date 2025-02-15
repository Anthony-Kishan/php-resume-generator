<?php

class ResumeController extends Controller
{

    public function index($a = '', $b = '', $c = '')
    {
        echo "From Resume controller";
    }

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