<?php

$DB_HOST = "localhost";
$DB_NAME = "cms";
$DB_USER = "root";
$DB_PASS = "";

try {
    $db = new PDO("mysql:host=$DB_HOST;dbname=$DB_NAME",$DB_USER,$DB_PASS);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (Exception $ex) {
    echo $ex->getMessage();
}