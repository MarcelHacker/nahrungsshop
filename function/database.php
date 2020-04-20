<?php

/**
 * Php file for all functions for database
 * 
 * Used in the website and admin config
 * 
 */

define('DB_DATABASE', 'brainfooddb'); // defines for databased
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_HOST', '127.0.0.1');
define('DB_CHARSET', 'utf8');

function getDB()  // Database connection
{
  static $db;   // database
  if ($db instanceof PDO) {
    return $db;
  }
  $dsn = sprintf("mysql:host=%s;dbname=%s;charset=%s", DB_HOST, DB_DATABASE, DB_CHARSET);
  $db = new PDO($dsn, DB_USERNAME, DB_PASSWORD);
  return $db;
}

function printDBErrorMessage()  // For error messaging
{
  $info = getDB()->errorInfo();
  if (isset($info[2])) {
    return $info[2];
  }
  return '';
}
