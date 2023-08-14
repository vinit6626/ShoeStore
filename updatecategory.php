<?php
session_start();
require_once("db_conn.php");

// error_reporting(E_ALL);
// ini_set('display_errors', 1);

// Check if the form is submitted for updating the category
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
    // Retrieve form data
    $newCategoryName = sanitizeInput($_POST["categoryName"]);

     // Validate the input
     if (empty($newCategoryName)) {
        $errors["categoryName"] = "Category Name is required.";
    } elseif (strlen($newCategoryName) > 50) {
        $errors["categoryName"] = "Category Name cannot exceed 50 characters.";
    }

    $categoryId = $_GET["c_id"]; // Assuming the category ID is passed in the URL parameter 'c_id'

    // Perform validation for the new category name if needed
    if (empty($errors)) {
    // Update the category name in the database
    $stmt = "UPDATE categories SET c_name = ? WHERE c_id = ?";
    $stmt = mysqli_prepare($conn, $stmt);
    mysqli_stmt_bind_param($stmt, "si", $newCategoryName, $categoryId);

    $result = mysqli_stmt_execute($stmt);

    if ($result) {
        $_SESSION['message'] = "Category has been updated successfully.";
        header("location: viewcategory.php");
        exit;
    } else {
        $_SESSION['message'] = "Error updating the category: " . mysqli_error($conn);
        header("location: updatecategory.php?c_id=" . $categoryId); // Redirect back to the update page with the category ID in the URL
        exit;
    }


    mysqli_stmt_close($stmt);
}
}


// Get the category details from the database to pre-fill the form
if (isset($_GET['c_id'])) {
    $categoryId = $_GET['c_id'];
    $stmt = "SELECT c_name FROM categories WHERE c_id = ?";
    $stmt = mysqli_prepare($conn, $stmt);
    mysqli_stmt_bind_param($stmt, "i", $categoryId);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $categoryData = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);
}
}
else {
    // Redirect back to the login page if not logged in
    header("location: login.php");
    exit;
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" type="image/x-icon" href="./images/favicon.png">
  <title>Shoe Store - Add Shoe Category</title>
  <!-- Link to Bootstrap CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="./css/style.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>

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
<!-- Link to Bootstrap JS and jQuery (for the Navbar toggle) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

</body>
</html>
