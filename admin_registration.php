<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once("db_conn.php");

// Initialize error messages array
$errors = array();

function sanitizeInput($input){
  $input = str_replace(['(',')','"', ';'], '', $input);
  $input = strip_tags($input);
  $input = trim($input);
  $input = htmlentities($input, ENT_QUOTES, 'UTF-8');
  return $input;
}
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Retrieve form data
    $username = sanitizeInput($_POST["adminname"]);
    $email = sanitizeInput($_POST["adminemail"]);
    $password = sanitizeInput($_POST["adminPassword"]);
    $cpassword = sanitizeInput($_POST["cpassword"]);
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    $user_type = "Admin";


    if (empty($errors)) {

      // Check if the username is unique
      $query = "SELECT * FROM account WHERE username = ?";
      $stmt = mysqli_prepare($conn, $query);
      mysqli_stmt_bind_param($stmt, "s", $username);
      mysqli_stmt_execute($stmt);
      $result = mysqli_stmt_get_result($stmt);
      if (mysqli_num_rows($result) > 0) {
          $errors["adminname"] = "Admin Name is already taken. Please choose a different Admin Name.";
      }
      mysqli_stmt_close($stmt);
  
      // Check if the email is unique
      $query = "SELECT * FROM account WHERE username = ?";
      $stmt = mysqli_prepare($conn, $query);
      mysqli_stmt_bind_param($stmt, "s", $username);
      mysqli_stmt_execute($stmt);
      $result = mysqli_stmt_get_result($stmt);
      if (mysqli_num_rows($result) > 0) {
          $errors["adminemail"] = "Admin Email is already registered. Please use a different Admin Email.";
      }
      mysqli_stmt_close($stmt);

    }


    // If there are no errors, then insert data only
    if (empty($errors)) {
        // Prepare and execute the database insertion query
        $stmt = "INSERT INTO account (username,  email, password, user_type) VALUES (?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $stmt);
        mysqli_stmt_bind_param($stmt, "ssss",$username, $email, $hashedPassword, $user_type);

        $result = mysqli_stmt_execute($stmt);
        if ($result) {
            echo "Data inserted successfully!";
            header("location: admin_login.php");
            exit;
        } else {
            echo "Error: " . $stmt->error;
            header("location: admin_registration.php");
        }
        mysqli_stmt_close($stmt);
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
    <p class="text-white">Explore our latest collection of stylish shoes for every occasion.</p>
    
  </div>
</section>


<!-- Registration Section -->
<!-- Registration Section -->
<section class="registration-section py-5">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-md-6">
          <h2 class="mb-4 text-center">Admin Sign up</h2>
          <form method="POST" action="<?php echo $_SERVER['PHP_SELF'];?>" id="admin-registration-form">
            <!-- Form fields and error messages -->
            <div class="mb-3">
              <label for="adminname" class="form-label">Admin Name</label>
              <input type="text" class="form-control" id="adminname" name="adminname" placeholder="Admin Name"
                value="<?php echo isset($adminname) ? $adminname : ''; ?>">
              <span class="text-danger" id="adminname-error"><?php echo isset($errors['adminname']) ? $errors['adminname'] : ''; ?></span>
            </div>
            <div class="mb-3">
              <label for="adminemail" class="form-label">Admin Email</label>
              <input type="text" class="form-control" id="adminemail" name="adminemail" placeholder="Admin Email"
                value="<?php echo isset($adminemail) ? $adminemail : ''; ?>">
              <span class="text-danger" id="adminemail-error"><?php echo isset($errors['adminemail']) ? $errors['adminemail'] : ''; ?></span>
            </div>
            <div class="mb-3">
              <label for="adminPassword" class="form-label">Password</label>
              <input type="password" class="form-control" id="adminPassword" name="adminPassword" placeholder="Admin Password">
              <span class="text-danger" id="adminPassword-error"><?php echo isset($errors['adminPassword']) ? $errors['adminPassword'] : ''; ?></span>
            </div>
            <div class="mb-3">
              <label for="cpassword" class="form-label">Confirm Password</label>
              <input type="password" class="form-control" id="cpassword" name="cpassword" placeholder="Confirm Password">
              <span class="text-danger" id="cpassword-error"><?php echo isset($errors['cpassword']) ? $errors['cpassword'] : ''; ?></span>
            </div>
            <div class="text-center">
              <button type="submit" class="btn btn-primary">Sign up</button>
            </div>
            <div class="text-center mt-3">
              <a href="admin_login.php">Already a user</a>
            </div>
          </form>
        </div>
      </div>
    </div>
  </section>



<!-- Footer Section -->
<footer class="bg-dark text-white text-center py-5 footer-section">
    <i class="fa-brands fa-twitter px-3"></i>
    <i class="fa-brands fa-facebook-f px-3"></i>
    <i class="fa-brands fa-instagram px-3"></i>
    <i class="fa-solid fa-envelope px-3"></i>
  <p class="mt-2">&copy; 2023 Shoe Store. All rights reserved.</p>
</footer>


<!-- Link to Bootstrap JS and jQuery (for the Navbar toggle) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

</body>
</html>


<!-- JavaScript Section -->
<script>

  const form = document.getElementById("admin-registration-form");

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
    const adminemail = document.getElementById("adminemail").value.trim();
    const adminPassword = document.getElementById("adminPassword").value.trim();
    const cpassword = document.getElementById("cpassword").value.trim();

    // Clear previous error messages
    document.getElementById("adminname-error").textContent = "";
    document.getElementById("adminemail-error").textContent = "";
    document.getElementById("adminPassword-error").textContent = "";
    document.getElementById("cpassword-error").textContent = "";

    // Validate username
    if (adminname === "") {
      document.getElementById("adminname-error").textContent = "Admin Name is required.";
      isValid = false;
    }

    // Validate email
    if (adminemail === "") {
      document.getElementById("adminemail-error").textContent = "Admin Email is required.";
      isValid = false;
    } else if (!emailIsValid(adminemail)) {
      document.getElementById("adminemail-error").textContent = "Invalid email format.";
      isValid = false;
    }

    // Validate password
    if (adminPassword === "") {
      document.getElementById("adminPassword-error").textContent = "Password is required.";
      isValid = false;
    }

    // Validate confirm password
    if (cpassword === "") {
      document.getElementById("cpassword-error").textContent = "Confirm Password is required.";
      isValid = false;
    } else if (adminPassword !== cpassword) {
      document.getElementById("cpassword-error").textContent = "Passwords do not match.";
      isValid = false;
    }

    return isValid;
  }

  function emailIsValid(adminemail) {
    return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(adminemail);
  }
  
</script>