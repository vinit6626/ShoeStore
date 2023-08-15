<?php
session_start();
require_once("db_conn.php");

class Database {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }
    public function deleteBrand($brandId) {
        try {
            $stmt = "DELETE FROM brands WHERE b_id = ?";
            $stmt = mysqli_prepare($this->conn, $stmt);
            mysqli_stmt_bind_param($stmt, "i", $brandId);

            $result = mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);

            return $result;
        } catch (mysqli_sql_exception $e) {
            return false; 
        }
    }
}

if (isset($_GET['b_id'])) {
    $brandId = $_GET['b_id'];
    $db = new Database($conn);
    $result = $db->deleteBrand($brandId);
    if ($result) {
        $_SESSION['message'] = "Brand has been deleted successfully.";
    } else {
        $_SESSION['message'] = "Cannot delete the brand due to related records in the shoe table.";
    }
} else {
    $_SESSION['message'] = "Invalid brand ID.";
}
header("location: viewbrand.php");
exit;
?>
