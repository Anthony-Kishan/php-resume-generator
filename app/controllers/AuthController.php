<?php
# AuthController.php

class AuthController extends Controller
{
    public function signup()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['username'];
            $email = $_POST['email'];
            $password = $_POST['password'];

            $errors = [];

            $errors[] = checkFieldEmpty($name, 'Username');
            $errors[] = checkFieldEmpty($email, 'Email');
            $errors[] = checkFieldEmpty($password, 'Password');
            $errors[] = validateEmail($email);
            $errors[] = checkPassword($password);
            $errors[] = checkEmailExists($email);
            $errors[] = checkUsernameExists($name);

            $errors = array_filter($errors, function ($value) {
                return !is_null($value);
            });

            show($errors);

            if (!empty($errors)) {
                $this->index('user/signup', 'signup', $d = "Hello");
                return;
            }

            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

            $userData = [
                'name' => $name,
                'email' => $email,
                'password' => $hashedPassword
            ];

            $user = new User();
            $inserted = $user->insert($userData);

            if ($inserted) {
                $_SESSION['message'] = "Registration Successful.";
                redirect('home');
                exit;
            }

            // If insertion fails, show an error message
            // $this->index('user/signup', 'signup', ['error' => 'Registration failed. Please try again.']);
        } else {
            // Show the signup form
            $this->index('user/signup', 'signup');
        }
    }



    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'];
            $password = $_POST['password'];

            $user = new User();
            $userData = $user->first(['email' => $email]);

            if ($userData && password_verify($password, $userData['password'])) {
                $_SESSION['USER'] = $userData;

                redirect('home');
                exit;
            }
            $this->index('user/login', $b = 'login', ['error' => 'Invalid username or password.']);
        } else {
            $this->index('user/login', $b = 'login');
        }
    }

    public function logout()
    {
        session_unset();
        session_destroy();

        redirect('home');
        exit;
    }


    public function index($a = '', $b = '', $c = '', $d = [])
    {
        if ($b == 'login') {
            $this->view($a, $d);
        }
        if ($b == 'signup') {
            echo $d;
            $this->view($a, $d);
        }
    }
}
