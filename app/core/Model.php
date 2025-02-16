<?php


class Model extends Database
{
    function test()
    {
        $query = "SELECT * FROM `resumes`";
        $result = $this->query($query);
        show($result);
    }
}