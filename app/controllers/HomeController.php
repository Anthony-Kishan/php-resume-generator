<?php
# HomeController.php

class HomeController extends Controller
{
    public function index($a = '', $b = '', $c = '')
    {
        // echo "This is the Home Controller";
        $this->view('home');
    }
}