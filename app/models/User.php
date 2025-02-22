<?php
# User Model
class User
{
    use Model;

    protected $table = 'users';

    protected $allowedColumns = [
        'name',
    ];


    /**
     * Checks if the email already exists in the database.
     * 
     * @param string $email The email to check.
     * @return bool True if the email exists, false otherwise.
     */
    public function emailExists($email)
    {
        $result = $this->first(['email' => $email]);
        if (!empty($result)) {
            return true;
        }
        return false;
    }


    /**
     * Checks if the username already exists in the database.
     * 
     * @param string $username The username to check.
     * @return bool True if the username exists, false otherwise.
     */
    public function usernameExists($username)
    {
        $result = $this->first(['name' => $username]);
        if (!empty($result)) {
            return true;
        }

        return false;
    }


    /**
     * Checks if a user is logged in based on session data.
     * 
     * @return bool True if the user is logged in, false otherwise.
     */
    public static function is_logged_in()
    {
        return isset($_SESSION['USER']['id']);
    }
}
