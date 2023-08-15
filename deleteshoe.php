<?php
session_start();
require_once("db_conn.php");
class ShoeDatabase {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function deleteShoe($shoeId) {
        $filePath = $this->getShoeImagePath($shoeId);

        $deleteStmt = "DELETE FROM shoe WHERE s_id = ?";
        $deleteStmt = mysqli_prepare($this->conn, $deleteStmt);
        mysqli_stmt_bind_param($deleteStmt, "i", $shoeId);
        $deleteResult = mysqli_stmt_execute($deleteStmt);
        mysqli_stmt_close($deleteStmt);

        if ($deleteResult && file_exists($filePath)) {
            unlink($filePath);
        }
        return $deleteResult;
    }

    private function getShoeImagePath($shoeId) {
        $stmt = "SELECT product_image FROM shoe WHERE s_id = ?";
        $stmt = mysqli_prepare($this->conn, $stmt);
        mysqli_stmt_bind_param($stmt, "i", $shoeId);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $row = mysqli_fetch_assoc($result);
        mysqli_stmt_close($stmt);

        return ($row) ? $row['product_image'] : null;
    }
}
if (isset($_GET['s_id'])) {
    $shoeId = $_GET['s_id'];

    $shoeDb = new ShoeDatabase($conn);
    $deleteResult = $shoeDb->deleteShoe($shoeId);

    if ($deleteResult) {
        $_SESSION['message'] = "Shoe detail has been deleted successfully.";
    } else {
        $_SESSION['message'] = "Error deleting the shoe.";
    }
} else {
    $_SESSION['message'] = "Invalid shoe ID.";
}

header("location: viewshoes.php");
exit;
?>
