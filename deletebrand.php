<?php
session_start();
require_once("db_conn.php");

if (isset($_GET['b_id'])) {
    $brandId = $_GET['b_id'];

    try {
        // Prepare and execute the database deletion query
        $stmt = "DELETE FROM brands WHERE b_id = ?";
        $stmt = mysqli_prepare($conn, $stmt);
        mysqli_stmt_bind_param($stmt, "i", $brandId);

        $result = mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        if ($result) {
            $_SESSION['message'] = "Brand has been deleted successfully.";
        } else {
            $_SESSION['message'] = "Error deleting the brand.";
        }
    } catch (mysqli_sql_exception $e) {
        // Handle foreign key constraint error
        $_SESSION['message'] = "Cannot delete the brand. It is associated with other Shoes.";
    }
} else {
    $_SESSION['message'] = "Invalid brand ID.";
}

// Redirect back to the page displaying brands
header("location: viewbrand.php");
exit;
?>
