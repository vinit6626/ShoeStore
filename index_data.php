<!DOCTYPE html>
<html>
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
</head>
<body>
<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
define("INITIALIZING_DATABASE", 1);
require_once("db_conn.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if(isset($_POST["drop"])){
        mysqli_query($conn, "DROP DATABASE IF EXISTS DabhiStore");
        echo "<h1 style='text-align: center; color: red; margin-top: 45vh;'>DabhiStore Database Dropped Successfully and All Data Removed.</h1>";
        $submit = true;
        $drop = false;
    }else{
    mysqli_query($conn, "drop database if exists shoeStore");
    mysqli_query($conn, "create database shoeStore");
    mysqli_query($conn, "use shoeStore");

    $shoes = "CREATE TABLE IF NOT EXISTS shoes (
        shoeID INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL,
        brandName VARCHAR(200) NOT NULL,
        shoeName VARCHAR(200) NOT NULL
    ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4";
    mysqli_query($conn, $shoes);
    
    $shoeSizes = "CREATE TABLE IF NOT EXISTS shoeSizes (
        shoeID INT(11) UNSIGNED,
        size INT,
        PRIMARY KEY (shoeID),
        FOREIGN KEY (shoeID) REFERENCES shoes (shoeID)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";
    mysqli_query($conn, $shoeSizes);
    
    $gender = "CREATE TABLE IF NOT EXISTS gender (
        genderID INT(11) UNSIGNED,
        gender VARCHAR(10),
        PRIMARY KEY (genderID)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";
    mysqli_query($conn, $gender);


    $shoeSizes = "CREATE TABLE IF NOT EXISTS shoeSizes (
        shoeID INT,
        size INT,
        PRIMARY KEY (shoeID),
        FOREIGN KEY (shoeID) REFERENCES shoes (shoeID)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";
    mysqli_query($conn, $shoeSizes);

    $shoeDetails = "CREATE TABLE IF NOT EXISTS shoeDetails (
        shoeID INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL,
        productDescription VARCHAR(250) NOT NULL,
        shoesImage VARCHAR(100) NOT NULL,
        FOREIGN KEY (shoeID) REFERENCES shoes (shoeID)
    ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4";
    mysqli_query($conn, $shoeDetails);

    $users = "CREATE TABLE IF NOT EXISTS users (
        userID INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL,
        username VARCHAR(50) NOT NULL,
        email VARCHAR(200) NOT NULL,
        userPassword VARCHAR(100) NOT NULL
    ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4";
    mysqli_query($conn, $users);

    $admin = "CREATE TABLE IF NOT EXISTS admins (
        adminID INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL,
        adminname VARCHAR(50) NOT NULL,
        adminemail VARCHAR(200) NOT NULL,
        adminPassword VARCHAR(100) NOT NULL
    ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4";
    mysqli_query($conn, $admin);

    $contacts = "CREATE TABLE IF NOT EXISTS contacts (
        id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL,
        name VARCHAR(200) NOT NULL,
        email VARCHAR(200) NOT NULL,
        phone VARCHAR(10) NOT NULL,
        message VARCHAR(250) NOT NULL
    ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4;
    ";
    mysqli_query($conn, $contacts);

    

    echo "<h1 style='text-align: center; color: green; margin-top: 45vh;'>Database and Table are created Successfully.</h1>";
    echo "<form method='get' style='text-align: center; margin:10px;' action='home.php'> 
    <input type='submit' class='btn btn-primary' value='Go to home page'/></form>";
    $submit = false;
    $drop = true;
}
}else{
    $submit = true;
    $drop = false;
}
?>


<div class="container text-center" style="margin-top: 45vh;">
            <form method="POST">
                <?php if($submit){ ?>
                    <input type="submit" class="btn btn-success" style="margin-top: 0vh;" value="Initialize Database" />
                <?php } ?>
                <?php if($drop){ ?>
                    <input type="submit" class="btn btn-danger" name="drop" value="Drop Database" />
                <?php } ?>
                </form>
        </div>              
                
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</body>
</html>
