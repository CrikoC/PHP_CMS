<?php
// Define the core paths
defined("DS") ? null : define("DS", DIRECTORY_SEPARATOR);

//Main site
defined("SITE_ROOT") ? null : define("SITE_ROOT", $_SERVER['DOCUMENT_ROOT'].DS."PHP_CMS");

//Library path that contains all classes
defined("LIB_PATH") ? null : define("LIB_PATH", SITE_ROOT.DS."includes");

require_once(LIB_PATH.DS.'functions.php');
require_once(LIB_PATH.DS.'session.php');
require_once(LIB_PATH.DS.'database.php');
require_once(LIB_PATH.DS.'database_object.php');
require_once(LIB_PATH.DS.'users.php');
require_once(LIB_PATH.DS.'users_online.php');
require_once(LIB_PATH.DS.'categories.php');
require_once(LIB_PATH.DS.'posts.php');
require_once(LIB_PATH.DS.'comments.php');
require_once(LIB_PATH.DS.'pagination.php');
require_once(LIB_PATH.DS.'mail_trap.php');
