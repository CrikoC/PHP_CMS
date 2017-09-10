<?php
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
        $query = Post::find_by_column('status','"published"');
        return static::find_by_sql($query);
    }

    public static function find_by_category($id="") {
        $query = "SELECT * FROM posts";
        $query .= " WHERE category_id = $id";
        $query .= "AND status = 'published'";
        return static::find_by_sql($query);
    }
}