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
          <form method="POST" action="<?php echo $_SERVER['PHP_SELF'];?>" id="registration-form" onsubmit="return validateForm();">
            <!-- Form fields and error messages -->
            <div class="mb-3">
              <label for="username" class="form-label">Username</label>
              <input type="text" class="form-control" id="username" name="username" placeholder="User Name"
                value="<?php echo isset($username) ? $username : ''; ?>">
              <span class="text-danger" id="username-error"><?php echo isset($errors['username']) ? $errors['username'] : ''; ?></span>
            </div>
            <div class="mb-3">
              <label for="email" class="form-label">Email</label>
              <input type="email" class="form-control" id="email" name="email" placeholder="Email"
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
