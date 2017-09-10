<?php
require_once(LIB_PATH.DS.'database.php');

class Comment extends DatabaseObject
{
    protected static $table_name = 'comments';
    protected static $db_fields = [
        'id',
        'post_id',
        'author',
        'email',
        'content',
        'status',
        'date'
    ];


    public $id;
    public $post_id;
    public $author;
    public $email;
    public $content;
    public $status;
    public $date;

    public static function find_by_post($id="") {
        $sql = "SELECT * FROM comments ";
        $sql .= "WHERE post_id = $id ";
        $sql .= "AND status = 'approved'";
        return static::find_by_sql($sql);
    }

    public static function find_by_post_admin($id="") {
        $sql = "SELECT * FROM comments ";
        $sql .= " WHERE post_id = $id";
        return static::find_by_sql($sql);
    }
}