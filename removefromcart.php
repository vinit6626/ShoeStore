<?php
require_once("db_conn.php");

if ($_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET['c_id'])) {
    $c_id = $_GET['c_id'];

    // Prepare and execute the DELETE query
    $sql = "DELETE FROM cart WHERE c_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $c_id);
    $stmt->execute();

    // Redirect back to the cart page after successful deletion
    header("location: cart.php");
    exit;
} else {
    header("location: cart.php");

    // If the c_id is not provided or the request method is not GET, handle the error appropriately
    echo "Invalid request!";
    exit();
}
?>
