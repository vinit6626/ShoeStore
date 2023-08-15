<?php
session_start();
require_once("db_conn.php");

class Database {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function insertBrand($brandName) {
        $stmt = "INSERT INTO brands (b_name) VALUES (?)";
        $stmt = mysqli_prepare($this->conn, $stmt);
        mysqli_stmt_bind_param($stmt, "s", $brandName);

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
        $brandName = sanitizeInput($_POST["brandName"]);

        $database = new Database($conn);

        $errors = array();

        if (empty($brandName)) {
            $errors["brandName"] = "Brand Name is required.";
        } elseif (strlen($brandName) > 50) {
            $errors["brandName"] = "Brand Name cannot exceed 50 characters.";
        }

        if (empty($errors)) {
            $result = $database->insertBrand($brandName);
            if ($result) {
                $_SESSION['message'] = $brandName . " has been inserted successfully. <a href='viewbrand.php'> Click here to view all Brand</a>";
                header("location: insertbrand.php");
                exit;
            } else {
                echo "Error inserting data.";
                header("location: insertbrand.php");
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
    <h2 class="mb-4">Add New Shoe Brand</h2>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
    <div class="mb-3">
        <label for="brandName" class="form-label">Brand Name:</label>
        <input type="text" class="form-control" id="brandName" name="brandName" placeholder="Brand Name" value="<?php echo isset($brandName) ? $brandName : ''; ?>">
        <span class="text-danger"><?php echo isset($errors['brandName']) ? $errors['brandName'] : ''; ?></span>
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