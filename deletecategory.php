<?php
session_start();
require_once("db_conn.php");

class CategoryManager {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function deleteCategory($categoryId) {
        try {
            $stmt = "DELETE FROM categories WHERE c_id = ?";
            $stmt = mysqli_prepare($this->conn, $stmt);
            mysqli_stmt_bind_param($stmt, "i", $categoryId);

            $result = mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);

            if ($result) {
                return "Category has been deleted successfully.";
            } else {
                return "Cannot delete the category due to related records in the shoe table.";
            }
        } catch (mysqli_sql_exception $e) {
            return "Cannot delete the category due to related records in the shoe table.";
        }
    }
}

if (isset($_GET['c_id'])) {
    $categoryId = $_GET['c_id'];

    $categoryManager = new CategoryManager($conn);
    $message = $categoryManager->deleteCategory($categoryId);

    $_SESSION['message'] = $message;
} else {
    $_SESSION['message'] = "Invalid category ID.";
}

header("location: viewcategory.php");
exit;
?>