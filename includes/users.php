<?php
require_once(LIB_PATH.DS.'database.php');

class User extends DatabaseObject
{
    protected static $table_name = 'users';
    protected static $db_fields = [
        'id',
        'username',
        'password',
        'first_name',
        'last_name',
        'email',
        'image',
        'role',
        'status',
        'token'
    ];

    public $id;
    public $username;
    public $password;
    public $first_name;
    public $last_name;
    public $email;
    public $role;
    public $status;
    public $token;

    public $image;
    public $image_temp;

    public static function username_exists($username) {
        $query = "SELECT * FROM users WHERE username = $username";
        $existing_user = User::find_by_sql($query);
        if(count($existing_user) > 0) {
            return true;
        } else {
            return false;
        }
    }

    public static function email_exists($email) {
        $query = "SELECT * FROM users WHERE email = $email";
        $existing_user = User::find_by_sql($query);
        if(count($existing_user) > 0) {
            return true;
        } else {
            return false;
        }
    }
}