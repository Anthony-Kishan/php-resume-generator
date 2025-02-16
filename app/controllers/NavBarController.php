<?php
# NavBarController

require_once '../models/User.php';

class NavBarController extends Controller
{
    public function index()
    {
        // Check if user is logged in
        $is_logged_in = User::is_logged_in();

        $this->view('navbar');
    }
}
