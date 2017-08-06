<?php
// If it's going to need the database, then it's
// probably smart to require it before we start.
require_once(LIB_PATH.DS.'database.php');

class DatabaseObject {
    protected static $table_name;
    protected static $db_fields;
    // Common Database Methods
    public static function find_all() {
        $sql = "SELECT * FROM ".static::$table_name;
        return static::find_by_sql($sql);
    }

    public static function find_limited($limit) {
        $sql = "SELECT * FROM ".static::$table_name." LIMIT ".$limit;
        return static::find_by_sql($sql);
    }

    public static function find_by_id($id="") {
        global $database;
        $sql = "SELECT * FROM ".static::$table_name;
        $sql .= " WHERE id='" .$database->escape_value($id)."'";
        $sql .= " LIMIT 1";
        $result_array = static::find_by_sql($sql);
        return !empty($result_array) ? array_shift($result_array) : false;
    }

    public static function find_by_column($column_name,$column_value) {
        global $database;
        $sql = "SELECT * FROM ".static::$table_name;
        $sql .= " WHERE $column_name='" .$database->escape_value($column_value)."'";

        $sql .= " LIMIT 1";
        $result_array = static::find_by_sql($sql);
        return !empty($result_array) ? array_shift($result_array) : false;
    }

    public static function count_all() {
        global $database;
        $sql = "SELECT COUNT(*) FROM ".static::$table_name;
        $result_set = $database->query($sql);
        $row = $database->fetch_array($result_set);
        return array_shift($row);
    }

    public static function count_by_id($id="") {
        global $database;
        $sql = "SELECT COUNT(*) FROM ".static::$table_name;
        $sql .= " WHERE id='".$database->escape_value($id)."'";
        $result_set = $database->query($sql);
        $row = $database->fetch_array($result_set);
        return array_shift($row);
    }

    public static function count_by_input($input="") {
        global $database;
        $sql = "SELECT COUNT(*) FROM ".static::$table_name;
        $sql .= " WHERE tags LIKE '".$database->escape_value($input)."'";
        $result_set = $database->query($sql);
        $row = $database->fetch_array($result_set);
        return array_shift($row);
    }

    public static function count_by_column($column_name,$column_value) {
        global $database;
        $sql = "SELECT COUNT(*) FROM ".static::$table_name;
        $sql .= " WHERE $column_name = '".$database->escape_value($column_value)."'";
        $result_set = $database->query($sql);
        $row = $database->fetch_array($result_set);
        return array_shift($row);
    }

    public static function find_by_sql($sql="") {
        global $database;
        $result_set = $database->query($sql);
        $object_array = array();
        while ($row = $database->fetch_array($result_set)) {
            $object_array[] = static::instantiate($row);
        }
        return $object_array;
    }

    public static function update_sql($sql="") {
        global $database;
        $result_set = $database->query($sql);
    }

    private static function instantiate($record) {
        // Could check that $record exists and is an array
        $class_name = get_called_class();
        $object = new $class_name;
        // More dynamic, short-form approach:
        foreach($record as $attribute=>$value){
            if($object->has_attribute($attribute)) {
                $object->$attribute = $value;
            }
        }
        return $object;
    }


    public function has_attribute($attribute) {
        // We don't care about the value, we just want to know if the key exists
        // Will return true or false
        return array_key_exists($attribute, $this->attributes());
    }

    protected function attributes() {
        // return an array of attribute names and their values
        $attributes = array();
        foreach(static::$db_fields as $field) {
            if(property_exists($this, $field)) {
                $attributes[$field] = $this->$field;
            }
        }
        return $attributes;
    }

    protected function sanitized_attributes() {
        global $database;
        $clean_attributes = array();
        // sanitize the values before submitting
        // Note: does not alter the actual value of each attribute
        foreach($this->attributes() as $key => $value){
            $clean_attributes[$key] = $database->escape_value($value);
        }
        return $clean_attributes;
    }

    public function create() {
        global $database;

        $attributes = $this->sanitized_attributes();
        $sql = "INSERT INTO ".static::$table_name." (";
        $sql .= join(", ", array_keys($attributes));
        $sql .= ") VALUES ('";
        $sql .= join("', '", array_values($attributes));
        $sql .= "')";
        if($database->query($sql)) {
            return true;
        } else {
            return false;
        }
    }

    public function update() {
        global $database;

        $attributes = $this->sanitized_attributes();
        $attribute_pairs = array();

        foreach($attributes as $key => $value) {
            $attribute_pairs[] = "{$key}='{$value}'";
        }
        $sql = "UPDATE ".static::$table_name." SET ";
        $sql .= join(", ", $attribute_pairs);
        $sql .= " WHERE id='".$database->escape_value($this->id)."'";
        $database->query($sql);
        return ($database->affected_rows() == 1) ? true : false;
    }

    public function delete() {
        global $database;

        $sql = "DELETE FROM ".static::$table_name;
        $sql .= " WHERE id='".$database->escape_value($this->id)."'";
        $sql .= " LIMIT 1";
        $database->query($sql);
        return ($database->affected_rows() == 1) ? true : false;
    }

    public function upload_image($image_temp, $image) {
        move_uploaded_file($image_temp, SITE_ROOT."/public/includes/images/$image");
    }
}