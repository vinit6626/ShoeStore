<?php
session_start();
require_once("db_conn.php");
class Database {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function deleteContactMessage($messageId) {
        $stmt = $this->conn->prepare("DELETE FROM contact_us WHERE cu_id = ?");
        $stmt->bind_param("i", $messageId);

        return $stmt->execute();
    }
}

if (isset($_GET['cu_id'])) {
    $messageId = $_GET['cu_id'];
    $db = new Database($conn);
    $result = $db->deleteContactMessage($messageId);

    if ($result) {
        $_SESSION['message'] = "Message has been deleted successfully.";
    } else {
        $_SESSION['message'] = "Error deleting the message.";
    }
} else {
    $_SESSION['message'] = "Invalid message ID.";
}

header("location: viewmessages.php");
exit;
?>
