<?php
# User Model
class User
{
    use Model;

    protected $table = 'users';

    protected $allowedColumns = [
        'name',
    ];


    public static function is_logged_in()
    {
        return isset($_SESSION['user_id']) && isset($_SESSION['username']);
    }

    public function validate($data)
    {
        $this->errors = [];

        if (empty($data['email'])) {
            $this->errors['email'] = 'Email is required';
        } else {
            if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
                $this->errors['email'] = 'Invalid email format';
            }
        }

        if (empty($data['password'])) {
            $this->errors['password'] = 'Password is required';
        }


        if (empty($this->errors)) {
            return true;
        }

        return false;
    }
}
