<?php
# LoginController.php

class LoginController extends Controller
{
    
    public function index($a = '', $b = '', $c = '')
    {
        $this->view('user/login');
    }
}
