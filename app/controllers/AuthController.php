<?php
# AuthController.php

class AuthController extends Controller
{
    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';

            $userModel = new User();
            $user = $userModel->first($email);

            if ($user && $user['password'] == $password) {
                session_start();
                $_SESSION['user'] = $user['user'];

                // header('Location: /home');
                redirect('home');
                exit; // Ensure the script stops here
            }


            // $this->view('user/login', ['error' => 'Invalid username or password.']);
            $this->index('user/login', ['error' => 'Invalid username or password.']);
        } else {
            // $this->view('user/login');
            $this->index($a = 'user/login');
        }
    }

    public function index($a = '', $b = '', $c = '', $d = [])
    {
        // $this->view('user/login');
        show($a);
        show($d);

        $this->view($a, $d);
    }
}
