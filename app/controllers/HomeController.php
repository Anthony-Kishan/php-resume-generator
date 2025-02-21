<?php
# HomeController.php

class HomeController extends Controller
{
    public function index($a = '', $b = '', $c = '')
    {
        // show("From the index method of HomeController");
        $this->view('home');
    }
}
