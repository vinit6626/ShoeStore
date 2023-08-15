<?php
session_start();
require_once("db_conn.php");

class BrandUpdater {
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

    public function updateBrand($newBrandName, $brandId) {
        $stmt = "UPDATE brands SET b_name = ? WHERE b_id = ?";
        $stmt = mysqli_prepare($this->conn, $stmt);
        mysqli_stmt_bind_param($stmt, "si", $newBrandName, $brandId);

        if (mysqli_stmt_execute($stmt)) {
            return true;
        } else {
            return false;
        }
        mysqli_stmt_close($stmt);
    }

    public function getBrandData($brandId) {
        $stmt = "SELECT b_name FROM brands WHERE b_id = ?";
        $stmt = mysqli_prepare($this->conn, $stmt);
        mysqli_stmt_bind_param($stmt, "i", $brandId);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $brandData = mysqli_fetch_assoc($result);
        mysqli_stmt_close($stmt);
        return $brandData;
    }
}

if (isset($_SESSION['username'])) {
    $brandUpdater = new BrandUpdater($conn);

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $newBrandName = $brandUpdater->sanitizeInput($_POST["brandName"]);
        if (empty($newBrandName)) {
            $errors["brandName"] = "Brand Name is required.";
        } elseif (strlen($newBrandName) > 50) {
            $errors["brandName"] = "Brand Name cannot exceed 50 characters.";
        }

        $brandId = $_GET["b_id"];
        if (empty($errors)) {
            if ($brandUpdater->updateBrand($newBrandName, $brandId)) {
                $_SESSION['message'] = "Brand has been updated successfully.";
                header("location: viewbrand.php");
                exit;
            } else {
                $_SESSION['message'] = "Error updating the category: " . mysqli_error($conn);
                header("location: updatebrand.php?b_id=" . $brandId);
                exit;
            }
        }
    }

    if (isset($_GET['b_id'])) {
        $brandId = $_GET['b_id'];
        $brandData = $brandUpdater->getBrandData($brandId);
    }
} else {
    header("location: login.php");
    exit;
}
?>

<?php require_once('header.php'); ?>
<?php require_once('navbar.php'); ?>
<div class="container mt-5 width40 mb-5">
        <h2 class="mb-4">Update Shoe Brand</h2>
        <form action="<?php echo $_SERVER['PHP_SELF'] . '?b_id=' . $brandId; ?>" method="post">
            <div class="mb-3">
                <label for="brandName" class="form-label">Brand Name:</label>
                <input type="text" class="form-control" id="brandName" name="brandName" placeholder="Brand Name" value="<?php echo isset($brandData['b_name']) ? $brandData['b_name'] : ''; ?>">
                <span class="text-danger"><?php echo isset($errors['brandName']) ? $errors['brandName'] : ''; ?></span>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>

<?php require_once('footer.php'); ?>