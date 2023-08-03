<?php
session_start();
// error_reporting(E_ALL);
// ini_set('display_errors', 1);

require_once("db_conn.php");

function sanitizeInput($input){
  $input = str_replace(['(',')','"', ';'], '', $input);
  $input = strip_tags($input);
  $input = trim($input);
  $input = htmlentities($input, ENT_QUOTES, 'UTF-8');
  return $input;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Retrieve form data
    $adminname = sanitizeInput($_POST["adminname"]);
    $adminPassword = sanitizeInput($_POST["adminPassword"]);

    // Validate the input (you can also use additional checks)
    if (empty($adminname) || empty($adminPassword)) {
        // Handle validation errors
        echo "Please enter both username and password.";
        exit;
    }
// echo "Please enter";
// die;
    // Retrieve hashed password from the database based on the username
    $stmt = "SELECT password FROM account WHERE username = ?";
    $stmt = mysqli_prepare($conn, $stmt);
    mysqli_stmt_bind_param($stmt, "s", $adminname);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);
    $hashedPassword = $row['password'];
    mysqli_stmt_close($stmt);

    // Verify the password
    if (password_verify($adminPassword, $hashedPassword)) {
        // Password is correct, log in the user
        $_SESSION['username'] = $adminname;
        $_SESSION['usertype'] = "Admin";

        header("location: home.php"); // Redirect to the dashboard or another authorized page
        exit;
    } else {
        // Password is incorrect, show an error message or redirect back to the login page
      
        echo "<div class='alert alert-danger alert-dismissible fade show' role='alert' style='margin-bottom: 0px;'>Invalid user name or password.<button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button></div>";
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" type="image/x-icon" href="./images/favicon.png">
  <title>Shoe Store</title>
  <!-- Link to Bootstrap CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="./css/style.css">
  
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

</head>
<body>
<?php require_once('navbar.php'); ?>


<!-- Welcome Section with Image -->
<section class="hero-section custom-bg homepage-heading-section">
  <div class="container text-center homepage-heading-div">
    <h1 class="text-white">Welcome to Shoe Store</h1>
    <p class="text-white">Login now and access our service.</p>
    
  </div>
</section>


<!-- Login Section -->
<section class="login-section py-5">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-6">
        <h2 class="mb-4 text-center">Admin Login</h2>
        <form method="POST" action="<?php echo $_SERVER['PHP_SELF'];?>" id="admin-login-form">
          <div class="mb-3">
            <label for="adminname" class="form-label">Admin Name</label>
            <input type="text" class="form-control" id="adminname" name="adminname" placeholder="Admin User Name">
            <span class="text-danger" id="adminname-error"><?php echo isset($errors['adminname']) ? $errors['adminname'] : ''; ?></span>

          </div>
          <div class="mb-3">
            <label for="adminPassword" class="form-label">Password</label>
            <input type="password" class="form-control" id="adminPassword" name="adminPassword" placeholder="Admin Password">
            <span class="text-danger" id="adminPassword-error"><?php echo isset($errors['adminPassword']) ? $errors['adminPassword'] : ''; ?></span>

          </div>
          <div class="text-center">
            <button type="submit" class="btn btn-primary">Login</button>
          </div>
          <div class="text-center mt-3">
            <a href="admin_registration.php">Create Account</a>
          </div>
        </form>
      </div>
    </div>
  </div>
</section>


<!-- Footer Section -->
<footer class="bg-dark text-white text-center py-5 footer-section">
    <a href="https://www.facebook.com/" target="_blank"><i class="fa-brands fa-twitter px-3"></i></a>
    <a href="https://twitter.com/" target="_blank"><i class="fa-brands fa-facebook-f px-3"></i></a>
    <a href="https://www.instagram.com/" target="_blank"><i class="fa-brands fa-instagram px-3"></i></a>
    <a href="https://mail.google.com/" target="_blank"><i class="fa-solid fa-envelope px-3"></i></a>
  <p class="mt-2">&copy; 2023 Shoe Store. All rights reserved.</p>
</footer>


<!-- Link to Bootstrap JS and jQuery (for the Navbar toggle) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

</body>
</html>



<!-- JavaScript Section -->
<script>
  const form = document.getElementById("admin-login-form");

  form.addEventListener("submit", function(event) {
    event.preventDefault(); // Prevent form submission to check validation

    // Validate the form fields
    const isValid = validateForm();

    // If all fields are valid, submit the form
    if (isValid) {
      form.submit();
    }
  });

  function validateForm() {
    let isValid = true;
    const adminname = document.getElementById("adminname").value.trim();
    const adminPassword = document.getElementById("adminPassword").value.trim();

    // Clear previous error messages
    document.getElementById("adminname-error").textContent = "";
    document.getElementById("adminPassword-error").textContent = "";

    // Validate username
    if (adminname === "") {
      document.getElementById("adminname-error").textContent = "Admin Username is required.";
      isValid = false;
    }

    // Validate password
    if (adminPassword === "") {
      document.getElementById("adminPassword-error").textContent = "Admin Password is required.";
      isValid = false;
    }

    return isValid;
  }

</script>