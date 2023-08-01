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



  
<section class="order-page py-5">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <h2 class="text-center mb-4">Shoe Product Details</h2>
      </div>
    </div>
    <div class="row">
      <div class="col-md-12">
        <table class="table table-striped">
          <thead>
            <tr>
              <th>Brand Name</th>
              <th>Shoe Name</th>
              <th>Gender</th>
              <th>Available Sizes</th>
              <th>Product Description</th>
              <th>Product Image</th>
              <th>Edit</th>
              <th>Delete</th>
            </tr>
          </thead>
          <tbody>
            <!-- Dummy data for the order details -->
            <tr>
              <td>Product 1</td>
              <td>$29.99</td>
              <td>2</td>
              <td>$59.98</td>
              <td>$59.98</td>
              <td>$59.98</td>
              <td><button class="btn btn-primary"> Edit</button></td>
              <td><button class="btn btn-danger">Delete</button></td>
            </tr>
            
            <!-- Add more rows for other products in the order -->
          </tbody>
         
        </table>
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
