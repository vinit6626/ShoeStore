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
    $username = sanitizeInput($_POST["username"]);
    $email = sanitizeInput($_POST["email"]);
    $password = sanitizeInput($_POST["password"]);
    $cpassword = sanitizeInput($_POST["cpassword"]);
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);


    if (empty($errors)) {

      // Check if the username is unique
      $query = "SELECT * FROM users WHERE username = ?";
      $stmt = mysqli_prepare($conn, $query);
      mysqli_stmt_bind_param($stmt, "s", $username);
      mysqli_stmt_execute($stmt);
      $result = mysqli_stmt_get_result($stmt);
      if (mysqli_num_rows($result) > 0) {
          $errors["username"] = "Username is already taken. Please choose a different username.";
      }
      mysqli_stmt_close($stmt);
  
      // Check if the email is unique
      $query = "SELECT * FROM users WHERE email = ?";
      $stmt = mysqli_prepare($conn, $query);
      mysqli_stmt_bind_param($stmt, "s", $email);
      mysqli_stmt_execute($stmt);
      $result = mysqli_stmt_get_result($stmt);
      if (mysqli_num_rows($result) > 0) {
          $errors["email"] = "Email is already registered. Please use a different email.";
      }
      mysqli_stmt_close($stmt);

    }


    // If there are no errors, then insert data only
    if (empty($errors)) {
        // Prepare and execute the database insertion query
        $stmt = "INSERT INTO users (username, email, userPassword) VALUES (?, ?, ?)";
        $stmt = mysqli_prepare($conn, $stmt);
        mysqli_stmt_bind_param($stmt, "sss", $username, $email, $hashedPassword);

        $result = mysqli_stmt_execute($stmt);
        if ($result) {
            echo "Data inserted successfully!";
            header("location: login.php");
            exit;
        } else {
            echo "Error: " . $stmt->error;
            header("location: registration.php");
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


<!-- Navigation Bar -->
<nav class="navbar navbar-expand-lg bg-dark navbar-dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="index.php">Shoe Store</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarText">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link" href="index.php">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="product.php">Products</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="about.php">About</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="contact.php">Contact</a>
        </li>
      </ul>
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" href="login.php">Login</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="registration.php">Register</a>
        </li>
      </ul>
    </div>
  </div>
</nav>




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
          <h2 class="mb-4 text-center">Sign up</h2>
          <form method="POST" action="<?php echo $_SERVER['PHP_SELF'];?>" id="registration-form">
            <!-- Form fields and error messages -->
            <div class="mb-3">
              <label for="username" class="form-label">Username</label>
              <input type="text" class="form-control" id="username" name="username" placeholder="User Name"
                value="<?php echo isset($username) ? $username : ''; ?>">
              <span class="text-danger" id="username-error"><?php echo isset($errors['username']) ? $errors['username'] : ''; ?></span>
            </div>
            <div class="mb-3">
              <label for="email" class="form-label">Email</label>
              <input type="text" class="form-control" id="email" name="email" placeholder="Email"
                value="<?php echo isset($email) ? $email : ''; ?>">
              <span class="text-danger" id="email-error"><?php echo isset($errors['email']) ? $errors['email'] : ''; ?></span>
            </div>
            <div class="mb-3">
              <label for="password" class="form-label">Password</label>
              <input type="password" class="form-control" id="password" name="password" placeholder="Password">
              <span class="text-danger" id="password-error"><?php echo isset($errors['password']) ? $errors['password'] : ''; ?></span>
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
              <a href="login.php">Already a user</a>
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

  const form = document.getElementById("registration-form");

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
    const email = document.getElementById("email").value.trim();
    const password = document.getElementById("password").value.trim();
    const cpassword = document.getElementById("cpassword").value.trim();

    // Clear previous error messages
    document.getElementById("username-error").textContent = "";
    document.getElementById("email-error").textContent = "";
    document.getElementById("password-error").textContent = "";
    document.getElementById("cpassword-error").textContent = "";

    // Validate username
    if (username === "") {
      document.getElementById("username-error").textContent = "Username is required.";
      isValid = false;
    }

    // Validate email
    if (email === "") {
      document.getElementById("email-error").textContent = "Email is required.";
      isValid = false;
    } else if (!emailIsValid(email)) {
      document.getElementById("email-error").textContent = "Invalid email format.";
      isValid = false;
    }

    // Validate password
    if (password === "") {
      document.getElementById("password-error").textContent = "Password is required.";
      isValid = false;
    }

    // Validate confirm password
    if (cpassword === "") {
      document.getElementById("cpassword-error").textContent = "Confirm Password is required.";
      isValid = false;
    } else if (password !== cpassword) {
      document.getElementById("cpassword-error").textContent = "Passwords do not match.";
      isValid = false;
    }

    return isValid;
  }

  function emailIsValid(email) {
    return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
  }
  
</script>