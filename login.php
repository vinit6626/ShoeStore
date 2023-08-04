<?php


session_start();
require_once("db_conn.php");

function sanitizeInput($input){
  $input = str_replace(['(',')','"', ';'], '', $input);
  $input = strip_tags($input);
  $input = trim($input);
  $input = htmlentities($input, ENT_QUOTES, 'UTF-8');
  return $input;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = sanitizeInput($_POST["username"]);
    $password = sanitizeInput($_POST["password"]);

    if (empty($username) || empty($password)) {
        // Handle validation errors
        echo "Please enter both username and password.";
        exit;
    }
    
    $stmt = "SELECT password, user_type, account_id FROM account WHERE username = ?";
    $stmt = mysqli_prepare($conn, $stmt);
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);

    if ($row && password_verify($password, $row['password'])) {
      
        $_SESSION['username'] = $username;
        $_SESSION['usertype'] = $row['user_type'];
        $_SESSION['user_id'] = $row['account_id'];
        
       
        if ($_SESSION['usertype'] === "Admin") {
            header("location: home.php"); 
        } elseif ($_SESSION['usertype'] === "User") {
            header("location: home.php"); 
        } else {
          header("location: login.php"); 
        }
        exit;
    } else {
        echo "<div class='alert alert-danger alert-dismissible fade show' role='alert' style='margin-bottom: 0px;'>Invalid username or password.<button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button></div>";
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
        <h2 class="mb-4 text-center">Login</h2>
        <form method="POST" action="<?php echo $_SERVER['PHP_SELF'];?>" id="login-form">
          <div class="mb-3">
            <label for="username" class="form-label">Username</label>
            <input type="text" class="form-control" id="username" name="username" placeholder="User Name">
            <span class="text-danger" id="username-error"><?php echo isset($errors['username']) ? $errors['username'] : ''; ?></span>

          </div>
          <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" id="password" name="password" placeholder="Password">
            <span class="text-danger" id="password-error"><?php echo isset($errors['password']) ? $errors['password'] : ''; ?></span>

          </div>
          <div class="text-center">
            <button type="submit" class="btn btn-primary">Login</button>
          </div>
          <div class="text-center mt-3">
            <a href="registration.php">Create Account</a>
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
  const form = document.getElementById("login-form");

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
    const username = document.getElementById("username").value.trim();
    const password = document.getElementById("password").value.trim();

    // Clear previous error messages
    document.getElementById("username-error").textContent = "";
    document.getElementById("password-error").textContent = "";

    // Validate username
    if (username === "") {
      document.getElementById("username-error").textContent = "Username is required.";
      isValid = false;
    }

    // Validate password
    if (password === "") {
      document.getElementById("password-error").textContent = "Password is required.";
      isValid = false;
    }

    return isValid;
  }

</script>