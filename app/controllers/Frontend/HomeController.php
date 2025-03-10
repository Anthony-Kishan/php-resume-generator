<?php
#HomeController.php

namespace App\Controllers\Frontend;

use App\Core\Controller;
use App\Models\Frontend\User;

class HomeController extends Controller
{
    public function index()
    {
        $this->view('home', [
            'is_logged_in' => User::is_logged_in()
        ]);
    }
}
