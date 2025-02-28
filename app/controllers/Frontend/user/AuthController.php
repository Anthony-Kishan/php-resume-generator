<?php
# AuthController.php

namespace App\Controllers\Frontend\User;

use App\Core\Controller;

class AuthController extends Controller
{
    public function signup()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = htmlspecialchars($_POST['username'], ENT_QUOTES, 'UTF-8');
            $email = htmlspecialchars($_POST['email'], ENT_QUOTES, 'UTF-8');
            $password = htmlspecialchars($_POST['password'], ENT_QUOTES, 'UTF-8');

            $errors = [];

            // Step 1: Check if username, email, and password are empty
            $errors[] = checkFieldEmpty($name, 'Username');
            $errors[] = checkFieldEmpty($email, 'Email');
            $errors[] = checkFieldEmpty($password, 'Password');

            // Filter out any null values for empty fields
            $errors = array_filter($errors, function ($value) {
                return !is_null($value);
            });

            // If any field is empty, return early with errors
            if (!empty($errors)) {
                $this->index('user/signup', 'signup', ['errors' => $errors, 'showModal' => true]);
                return;
            }

            // Step 2: Check if email format is valid (only if username and password are given)
            if (!empty($name) && !empty($password)) {
                $errors[] = validateEmail($email);
            }

            // Filter errors after checking email format
            $errors = array_filter($errors, function ($value) {
                return !is_null($value);
            });

            // If email format is invalid, return with errors
            if (!empty($errors)) {
                $this->index('user/signup', 'signup', ['errors' => $errors, 'showModal' => true]);
                return;
            }

            // Step 3: Check if email already exists (only if email is valid)
            if (!empty($email) && filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors[] = checkEmailExists($email);
            }

            // Step 5: Check password strength (only if password is not empty)
            if (!empty($password)) {
                $errors[] = checkPassword($password);
            }

            // Filter errors after checking all conditions
            $errors = array_filter($errors, function ($value) {
                return !is_null($value);
            });

            // If there are any errors, show them
            if (!empty($errors)) {
                $this->index('user/signup', 'signup', ['errors' => $errors, 'showModal' => true]);
                return;
            }

            // If there are no errors, proceed with registration
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
                redirect('auth/login');
                exit;
            }

            // If insertion fails, show an error message
            $this->index('user/signup', 'signup', ['error' => 'Registration failed. Please try again.']);
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


            $errors = [];

            $errors[] = checkFieldEmpty($email, 'Email');
            $errors[] = checkFieldEmpty($password, 'Password');
            $errors[] = validateEmail($email);

            $errors = array_filter($errors, function ($value) {
                return !is_null($value);
            });

            // show($errors);

            if (!empty($errors)) {
                $this->index('user/login', 'login', ['errors' => $errors, 'showModal' => true]);
                return;
            }


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


    public function index($a = '', $b = '', $d = [])
    {
        if ($b == 'login') {
            $this->view($a, $d);
        }
        if ($b == 'signup') {
            $this->view($a, $d);
        }
    }
}
