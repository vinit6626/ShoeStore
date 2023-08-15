<?php
session_start();
require_once("db_conn.php");
class Database {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function insertCategory($categoryName) {
        $stmt = "INSERT INTO categories (c_name) VALUES (?)";
        $stmt = mysqli_prepare($this->conn, $stmt);
        mysqli_stmt_bind_param($stmt, "s", $categoryName);

        return mysqli_stmt_execute($stmt);
    }
}
if (isset($_SESSION['username'])) {
    function sanitizeInput($input){
        $input = str_replace(['(',')','"', ';'], '', $input);
        $input = strip_tags($input);
        $input = trim($input);
        $input = htmlentities($input, ENT_QUOTES, 'UTF-8');
        $input = htmlspecialchars($input);
    
        return $input;
    }

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $categoryName = sanitizeInput($_POST["categoryName"]);

        $database = new Database($conn);

        $errors = array();

        if (empty($categoryName)) {
            $errors["categoryName"] = "Category Name is required.";
        } elseif (strlen($categoryName) > 50) {
            $errors["categoryName"] = "Category Name cannot exceed 50 characters.";
        }

        if (empty($errors)) {
            $result = $database->insertCategory($categoryName);
            if ($result) {
                $_SESSION['message'] = $categoryName . " has been inserted successfully. <a href='viewcategory.php'> Click here to view categories</a>";
                header("location: insertcategory.php");
                exit;
            } else {
                echo "Error inserting data.";
                header("location: insertcategory.php");
            }
        }
    }
} else {
    header("location: login.php");
    exit;
}
?>

<?php require_once('header.php'); ?>
<?php require_once('navbar.php'); ?>
<?php if (isset($_SESSION['message'])) : ?>
    <div class='alert alert-success alert-dismissible fade show' role='alert' style='margin-bottom: 0px;'>
<b><?php echo $_SESSION['message']; ?></b>
        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close' onclick='clearMessage()'></button>
    </div>
    <?php
    unset($_SESSION['message']);
    ?>
<?php endif; ?>


<div class="container mt-5 width40 mb-5">
    <h2 class="mb-4">Add New Shoe Category</h2>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
    <div class="mb-3">
        <label for="categoryName" class="form-label">Category Name:</label>
        <input type="text" class="form-control" id="categoryName" name="categoryName" placeholder="Category Name" value="<?php echo isset($categoryName) ? $categoryName : ''; ?>">
        <span class="text-danger"><?php echo isset($errors['categoryName']) ? $errors['categoryName'] : ''; ?></span>
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
</form>
  </div>

  <?php require_once('footer.php'); ?>
 

<script>
    function clearMessage() {
        window.location.href = window.location.href;
    }
</script>