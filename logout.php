<?php

session_start();
$_SESSION = array();
session_destroy();
echo '<script>alert("User is logout ")</script>';
header("location: login.php");

?>
