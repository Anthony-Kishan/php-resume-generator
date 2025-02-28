<?php

namespace App\Controllers\Frontend;

use App\Core\Controller;
use App\Models\Frontend\User;

class HomeController extends Controller
{
    public function index()
    {
        // Check if the user is logged in
        $is_logged_in = User::is_logged_in();

        // Pass the variable to the view
        $this->view('home', ['is_logged_in' => $is_logged_in]);
    }
}
