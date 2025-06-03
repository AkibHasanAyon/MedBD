<?php 
//Start Session

session_start();

//Create Constants to Store Non-repeating Value

define('SITEURL','http://localhost/pharma/');
// define('SITEURL','http://localhost:7888/pharma/');
define('LOCALHOST','localhost');
define('DB_USERNAME','root');
define('DB_PASSWORD','');
define('DB_NAME','medbd');

$conn=mysqli_connect(LOCALHOST,DB_USERNAME,DB_PASSWORD) or die(mysqli_error());//database connection
$db_select=mysqli_select_db($conn,DB_NAME) or die(mysqli_error());//delecting database

?>