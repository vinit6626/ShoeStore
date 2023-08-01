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

<div class="container mt-5 width40 mb-5">
    <h2 class="mb-4">Add New Shoe Product</h2>
    <form action="/submit" method="post">
      <div class="mb-3">
        <label for="brand" class="form-label">Brand Name:</label>
        <input type="text" class="form-control" id="brand" name="brand" placeholder="Shoe Brand">
      </div>
      <div class="mb-3">
        <label for="shoeName" class="form-label">Shoe Name:</label>
        <input type="text" class="form-control" id="shoeName" name="shoeName" placeholder="Shoe Name">
      </div>
      <div class="mb-3">
        <label class="form-label">Gender:</label>
        <div class="form-check">
          <input type="radio" class="form-check-input" id="male" name="gender" value="male" required>
          <label class="form-check-label" for="male">Male</label>
        </div>
        <div class="form-check">
          <input type="radio" class="form-check-input" id="female" name="gender" value="female">
          <label class="form-check-label" for="female">Female</label>
        </div>
      </div>
      <div class="mb-3">
        <label class="form-label">Available Sizes:</label>
        <div class="form-check form-check-inline">
          <input type="checkbox" class="form-check-input" id="sizeS" name="size[]" value="S">
          <label class="form-check-label" for="sizeS">S</label>
        </div>
        <div class="form-check form-check-inline">
          <input type="checkbox" class="form-check-input" id="sizeM" name="size[]" value="M">
          <label class="form-check-label" for="sizeM">M</label>
        </div>
        <div class="form-check form-check-inline">
          <input type="checkbox" class="form-check-input" id="sizeL" name="size[]" value="L">
          <label class="form-check-label" for="sizeL">L</label>
        </div>
      </div>
      <div class="mb-3">
        <label for="description" class="form-label">Product Description:</label>
        <textarea class="form-control" id="description" name="description" placeholder="Product Description"></textarea>
      </div>
      <div class="mb-3">
        <label for="productImage" class="form-label">Product Image:</label>
        <input type="file" class="form-control" id="productImage" name="productImage" accept="image/*" required>
      </div>
      <button type="submit" class="btn btn-primary">Submit</button>
    </form>
  </div>



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
