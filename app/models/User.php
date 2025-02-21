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
        return isset($_SESSION['user_id']);
    }
}
