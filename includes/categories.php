<?php
class Category extends DatabaseObject
{
    protected static $table_name = 'categories';
    protected static $db_fields = ['id', 'title'];

    public $id;
    public $title;
}