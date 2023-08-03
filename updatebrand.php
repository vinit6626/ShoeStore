<?php
require_once("db_conn.php");

// Check if the form is submitted for updating the category
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Retrieve form data
    $newBrandName = sanitizeInput($_POST["brandName"]);

     // Validate the input
     if (empty($newBrandName)) {
        $errors["brandName"] = "Brand Name is required.";
    } elseif (strlen($newBrandName) > 50) {
        $errors["brandName"] = "Brand Name cannot exceed 50 characters.";
    }

    $brandId = $_GET["b_id"]; 
    // Assuming the category ID is passed in the URL parameter 'c_id'

    // Perform validation for the new category name if needed
    if (empty($errors)) {
    // Update the category name in the database
    $stmt = "UPDATE brands SET b_name = ? WHERE b_id = ?";
    $stmt = mysqli_prepare($conn, $stmt);
    mysqli_stmt_bind_param($stmt, "si", $newBrandName, $brandId);

    $result = mysqli_stmt_execute($stmt);
        // echo "<pre>";
        // echo $newBrandName;
        // echo "</pre>";
    if ($result) {
        $_SESSION['message'] = "Brand has been updated successfully.";
        header("location: viewbrand.php");
        exit;
    } else {
        $_SESSION['message'] = "Error updating the category: " . mysqli_error($conn);
        header("location: updatebrand.php?b_id=" . $brandId); // Redirect back to the update page with the category ID in the URL
        exit;
    }
    mysqli_stmt_close($stmt);
    }
}

function sanitizeInput($input){
    $input = str_replace(['(',')','"', ';'], '', $input);
    $input = strip_tags($input);
    $input = trim($input);
    $input = htmlentities($input, ENT_QUOTES, 'UTF-8');
    return $input;
}

// Get the category details from the database to pre-fill the form
if (isset($_GET['b_id'])) {
    $brandId = $_GET['b_id'];
    $stmt = "SELECT b_name FROM brands WHERE b_id = ?";
    $stmt = mysqli_prepare($conn, $stmt);
    mysqli_stmt_bind_param($stmt, "i", $brandId);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $brandData = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);
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

<!-- Footer Section -->
<footer class="bg-dark text-white text-center py-5 footer-section">
    <!-- ... (footer social media links and copyright info) ... -->
</footer>

<!-- Link to Bootstrap JS and jQuery (for the Navbar toggle) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

</body>
</html>
