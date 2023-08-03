<?php
session_start();
require_once("db_conn.php");

// Check if the category id is provided in the URL
if (isset($_GET['b_id'])) {
    $brandId = $_GET['b_id'];

    // Prepare and execute the database deletion query
    $stmt = "DELETE FROM brands WHERE b_id = ?";
    $stmt = mysqli_prepare($conn, $stmt);
    mysqli_stmt_bind_param($stmt, "i", $brandId);

    $result = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    if ($result) {
        $_SESSION['message'] = "Brand has been deleted successfully.";
    } else {
        $_SESSION['message'] = "Error deleting the category.";
    }
} else {
    $_SESSION['message'] = "Invalid category ID.";
}

// Redirect back to the page displaying categories
header("location: viewbrand.php");
exit;
?>
