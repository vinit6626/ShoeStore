<?php
session_start();

require_once("db_conn.php");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Initialize error messages array
    $errors = array();

    // Retrieve form data
    $brandName = sanitizeInput($_POST["brandName"]);

    // Validate the input
    if (empty($brandName)) {
        $errors["brandName"] = "Brand Name is required.";
    } elseif (strlen($brandName) > 50) {
        $errors["brandName"] = "Brand Name cannot exceed 50 characters.";
    }


    // If there are no errors, then insert data only
    if (empty($errors)) {
        $stmt = "INSERT INTO brands (b_name) VALUES (?)";
        $stmt = mysqli_prepare($conn, $stmt);
        mysqli_stmt_bind_param($stmt, "s", $brandName);

        $result = mysqli_stmt_execute($stmt);
        if ($result) {
            $_SESSION['message'] = $brandName . " has been inserted successfully. <a href='viewbrand.php'> Click here to view all Brand</a>";
            header("location: insertbrand.php");
            exit;
        } else {
            echo "Error: " . $stmt->error;
            header("location: insertbrand.php");
        }
        mysqli_stmt_close($stmt);
    }
}

// Function to sanitize input (similar to your existing function)
function sanitizeInput($input){
    $input = str_replace(['(',')','"', ';'], '', $input);
    $input = strip_tags($input);
    $input = trim($input);
    $input = htmlentities($input, ENT_QUOTES, 'UTF-8');
    return $input;
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

<!-- Footer Section -->
<footer class="bg-dark text-white text-center py-5 footer-section">
    <!-- ... (footer social media links and copyright info) ... -->
</footer>

<!-- Link to Bootstrap JS and jQuery (for the Navbar toggle) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

</body>
</html>
<script>
    function clearMessage() {
        window.location.href = window.location.href;
    }
</script>