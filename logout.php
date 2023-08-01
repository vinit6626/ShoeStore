<?php
session_start();

// Destroy the user session to log out
session_destroy();

// Redirect the user to the login page after logout
header("location: login.php");
exit;
?>
