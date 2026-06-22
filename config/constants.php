<?php 
//Start Session

session_start();

//Create Constants to Store Non-repeating Value

define('SITEURL','http://localhost/MedBD/');
// define('SITEURL','http://localhost:7888/pharma/');
define('LOCALHOST','localhost');
define('DB_USERNAME','root');
define('DB_PASSWORD','');
define('DB_NAME','medbd');

// Load Environment Variables
$envPath = __DIR__ . '/../.env';
if (file_exists($envPath)) {
    $env = parse_ini_file($envPath);
    define('STRIPE_PUBLISHABLE_KEY', $env['STRIPE_PUBLISHABLE_KEY'] ?? '');
    define('STRIPE_SECRET_KEY', $env['STRIPE_SECRET_KEY'] ?? '');
    define('SMTP_USERNAME', $env['SMTP_USERNAME'] ?? '');
    define('SMTP_PASSWORD', $env['SMTP_PASSWORD'] ?? '');
} else {
    define('STRIPE_PUBLISHABLE_KEY', '');
    define('STRIPE_SECRET_KEY', '');
    define('SMTP_USERNAME', '');
    define('SMTP_PASSWORD', '');
}

$conn=mysqli_connect(LOCALHOST,DB_USERNAME,DB_PASSWORD) or die(mysqli_connect_error());//database connection
$db_select=mysqli_select_db($conn,DB_NAME) or die(mysqli_error($conn));//delecting database

?>