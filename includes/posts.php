<?php
require_once(LIB_PATH.DS.'database.php');

class Post extends DatabaseObject
{
    protected static $table_name = 'posts';
    protected static $db_fields = [
        'id',
        'title',
        'category_id',
        'author',
        'date',
        'content',
        'tags',
        'status',
        'image',
        'views'
    ];

    public $id;
    public $title;
    public $category_id;
    public $author;
    public $date;
    public $content;
    public $tags;
    public $status;
    public $views;

    public $image;
    public $image_temp;

    public static function find_published(){
        $sql = "SELECT * FROM posts ";
        $sql .= " WHERE status='published'";

        return static::find_by_sql($sql);
    }

    public static function find_by_category($id="") {
        global $database;
        $sql = "SELECT * FROM posts ";
        $sql .= " WHERE category_id='" .$database->escape_value($id)."' ";
        $sql .= "AND status='published'";

        return static::find_by_sql($sql);
    }
}