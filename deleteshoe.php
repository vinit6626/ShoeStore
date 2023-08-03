<?php
session_start();
require_once("db_conn.php");

// Check if the category id is provided in the URL
if (isset($_GET['s_id'])) {
    $shoeId = $_GET['s_id'];

    // Prepare and execute the database query to retrieve the file path of the image
    $stmt = "SELECT product_image FROM shoe WHERE s_id = ?";
    $stmt = mysqli_prepare($conn, $stmt);
    mysqli_stmt_bind_param($stmt, "i", $shoeId);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);

    if ($row) {
        $filePath = $row['product_image'];

        // Delete the shoe from the database
        $deleteStmt = "DELETE FROM shoe WHERE s_id = ?";
        $deleteStmt = mysqli_prepare($conn, $deleteStmt);
        mysqli_stmt_bind_param($deleteStmt, "i", $shoeId);
        $deleteResult = mysqli_stmt_execute($deleteStmt);
        mysqli_stmt_close($deleteStmt);

        // Delete the associated image file from the local computer
        if ($deleteResult && file_exists($filePath)) {
            unlink($filePath);
        }

        if ($deleteResult) {
            $_SESSION['message'] = "Shoe detail has been deleted successfully.";
        } else {
            $_SESSION['message'] = "Error deleting the shoe.";
        }
    } else {
        $_SESSION['message'] = "Shoe not found.";
    }

    // Close the database connection
    mysqli_stmt_close($stmt);
} else {
    $_SESSION['message'] = "Invalid shoe ID.";
}

// Redirect back to the page displaying shoes
header("location: viewshoes.php");
exit;
?>
