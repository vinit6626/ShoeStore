<?php
session_start();
require_once("db_conn.php");

class CartDeletion {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function deleteCartItem($c_id) {
        $sql = "DELETE FROM cart WHERE c_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $c_id);
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }
}
if (isset($_SESSION['username'])) {
    if ($_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET['c_id'])) {
        $c_id = $_GET['c_id'];

        $cartDeletion = new CartDeletion($conn);

        if ($cartDeletion->deleteCartItem($c_id)) {
            header("location: cart.php");
            exit;
        } else {
            echo "Error deleting item from cart.";
        }
    } else {
        header("location: cart.php");
        echo "Invalid request!";
    }
} else {
    header("location: login.php");
    exit;
}
?>
