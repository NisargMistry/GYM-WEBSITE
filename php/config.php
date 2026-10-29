<?php
/*
 * Database configuration
 * Default: MySQL root with no password (XAMPP/WAMP default)
 */

define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'nisarg');

// Base path for images (relative to web root)
define('IMG_PATH', '../assets/images/');

// Try connecting to the Database
$conn = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

// Check the connection
if ($conn == false) {
    die('Error: Cannot connect to database.');
}
?>
