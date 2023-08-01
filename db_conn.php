<?php
define("DB_HOST", "localhost:3307");
define("DB_USER", "root");
define("DB_PASSWORD", "");
define("DB_NAME", "shoeStore");
define("CHARSET", "utf8mb4");

$conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME) or die("Connection Failed: " . mysqli_connect_error());
mysqli_set_charset($conn, CHARSET);
?>
