<?php
# AuthController.php

class AuthController extends Controller
{
    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $user = new User();
            $arr['email'] = $_POST['email'];

            $row = $user->first($arr);

            if ($row) {
                if ($row['email'] && password_verify($_POST['password'], $row['password'])) {
                    session_start();
                    $_SESSION['USER'] = $row;
                    redirect('home');
                    exit;
                } else {
                    $this->index('user/login', $b = 'login', ['error' => 'Invalid username or password.']);
                }
            } else {
                $this->index('user/login', $b = 'login', ['error' => 'Invalid username or password.']);
            }
        } else {
            $this->index('user/login', $b = 'login');
        }
    }

    public function index($a = '', $b = '', $c = '', $d = [])
    {
        if ($b == 'login') {
            $this->view($a, $d);
        }
        if ($b == 'signup') {
            $this->view($a, $d);
        }
        if ($b == 'logout') {
            $this->view($a, $d);
        }
    }
}
