<?php
session_start();

// error_reporting(E_ALL);
// ini_set('display_errors', 1);

require_once("db_conn.php");

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
    // Initialize error messages array

    // echo "<pre>";
    // print_r($_POST);
    // echo "</pre>";
    // $errors = array();

    // Retrieve form data
    $categoryName = sanitizeInput($_POST["categoryName"]);

    // Validate the input
    if (empty($categoryName)) {
        $errors["categoryName"] = "Category Name is required.";
    } elseif (strlen($categoryName) > 50) {
        $errors["categoryName"] = "Category Name cannot exceed 50 characters.";
    }


    // If there are no errors, then insert data only
    if (empty($errors)) {
        $stmt = "INSERT INTO categories (c_name) VALUES (?)";
        $stmt = mysqli_prepare($conn, $stmt);
        mysqli_stmt_bind_param($stmt, "s", $categoryName);

        $result = mysqli_stmt_execute($stmt);
        if ($result) {
            $_SESSION['message'] = $categoryName . " has been inserted successfully. <a href='viewcategory.php'> Click here to view categories</a>";
            header("location: insertcategory.php");
            exit;
        } else {
            echo "Error: " . $stmt->error;
            header("location: insertcategory.php");
        }
        mysqli_stmt_close($stmt);
    }
}

// Function to sanitize input (similar to your existing function)

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