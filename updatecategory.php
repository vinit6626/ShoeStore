<?php
session_start();
require_once("db_conn.php");

class CategoryUpdater {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function sanitizeInput($input){
        $input = str_replace(['(',')','"', ';'], '', $input);
        $input = strip_tags($input);
        $input = trim($input);
        $input = htmlentities($input, ENT_QUOTES, 'UTF-8');
        $input = htmlspecialchars($input);
        return $input;
    }

    public function updateCategory($newCategoryName, $categoryId) {
        $stmt = "UPDATE categories SET c_name = ? WHERE c_id = ?";
        $stmt = mysqli_prepare($this->conn, $stmt);
        mysqli_stmt_bind_param($stmt, "si", $newCategoryName, $categoryId);

        if (mysqli_stmt_execute($stmt)) {
            return true;
        } else {
            return false;
        }
        mysqli_stmt_close($stmt);
    }

    public function getCategoryData($categoryId) {
        $stmt = "SELECT c_name FROM categories WHERE c_id = ?";
        $stmt = mysqli_prepare($this->conn, $stmt);
        mysqli_stmt_bind_param($stmt, "i", $categoryId);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $categoryData = mysqli_fetch_assoc($result);
        mysqli_stmt_close($stmt);
        return $categoryData;
    }
}

if (isset($_SESSION['username'])) {
    $categoryUpdater = new CategoryUpdater($conn);

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $newCategoryName = $categoryUpdater->sanitizeInput($_POST["categoryName"]);
        if (empty($newCategoryName)) {
            $errors["categoryName"] = "Category Name is required.";
        } elseif (strlen($newCategoryName) > 50) {
            $errors["categoryName"] = "Category Name cannot exceed 50 characters.";
        }

        $categoryId = $_GET["c_id"];
        if (empty($errors)) {
            if ($categoryUpdater->updateCategory($newCategoryName, $categoryId)) {
                $_SESSION['message'] = "Category has been updated successfully.";
                header("location: viewcategory.php");
                exit;
            } else {
                $_SESSION['message'] = "Error updating the category: " . mysqli_error($conn);
                header("location: updatecategory.php?c_id=" . $categoryId);
                exit;
            }
        }
    }

    if (isset($_GET['c_id'])) {
        $categoryId = $_GET['c_id'];
        $categoryData = $categoryUpdater->getCategoryData($categoryId);
    }
} else {
    header("location: login.php");
    exit;
}
?>

<?php require_once('header.php'); ?>
<?php require_once('navbar.php'); ?>
<div class="container mt-5 width40 mb-5">
        <h2 class="mb-4">Update Shoe Category</h2>
        <form action="<?php echo $_SERVER['PHP_SELF'] . '?c_id=' . $categoryId; ?>" method="post">
            <div class="mb-3">
                <label for="categoryName" class="form-label">Category Name:</label>
                <input type="text" class="form-control" id="categoryName" name="categoryName" placeholder="Category Name" value="<?php echo isset($categoryData['c_name']) ? $categoryData['c_name'] : ''; ?>">
                <span class="text-danger"><?php echo isset($errors['categoryName']) ? $errors['categoryName'] : ''; ?></span>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>


    <?php require_once('footer.php'); ?>