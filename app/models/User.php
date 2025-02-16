<?php
# User Model
class User
{
    public static function is_logged_in()
    {
        return isset($_SESSION['user_id']);
    }
}
