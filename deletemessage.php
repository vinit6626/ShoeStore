<?php
session_start();
require_once("db_conn.php");

// Check if the category id is provided in the URL
if (isset($_GET['cu_id'])) {
    $messageId = $_GET['cu_id'];

    // Prepare and execute the database deletion query
    $stmt = "DELETE FROM contact_us WHERE cu_id = ?";
    $stmt = mysqli_prepare($conn, $stmt);
    mysqli_stmt_bind_param($stmt, "i", $messageId);

    $result = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    if ($result) {
        $_SESSION['message'] = "Message has been deleted successfully.";
    } else {
        $_SESSION['message'] = "Error deleting the category.";
    }
} else {
    $_SESSION['message'] = "Invalid category ID.";
}

// Redirect back to the page displaying categories
header("location: viewmessages.php");
exit;
?>
