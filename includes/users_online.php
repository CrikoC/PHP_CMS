<?php
require_once(LIB_PATH.DS.'database.php');

class UserOnline extends DatabaseObject
{
    protected static $table_name = 'users_online';
    protected static $db_fields = [
        'id',
        'session',
        'time'
    ];

    public $id;
    public $session;
    public $time;
}