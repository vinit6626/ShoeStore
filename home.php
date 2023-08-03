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

<?php
  session_start();
  if (isset($_SESSION['username'])) {
    echo "<h1 class='text-center mt-2'>Welcome, " . $_SESSION['username'] . "!</h1><h2 class='text-center'>Hello, ". $_SESSION['usertype'] ."</h2>"; 
    // Show the logged-in user's name
  } else {
    // Redirect back to the login page if not logged in
    header("location: login.php");
    exit;
  }
  ?>
<!-- What is shoe store Section with Image -->
<section class="my-5">
  <div class="container">
    <div class="row homepage-section-info">
      <div class="col-md-8">
        <h2>What is Shoe Store.</h2>
        <p>Welcome to Shoe Store, your one-stop destination for the latest and trendiest footwear. We offer a wide selection of stylish shoes for men, women, and kids, suitable for different styles and occasions. Our collection includes sneakers, heels, boots, sandals, and much more.</p>
        <p>At Shoe Store, we are committed to providing not only high-quality shoes but also exceptional customer service. Our dedicated team of experts is always ready to assist you in finding the perfect pair of shoes that fit your style and comfort requirements.</p>
        <p>With years of experience in the shoe industry, we ensure that our customers have a seamless and enjoyable shopping experience. We offer cash on delivery options and provide delivery all over the country, making it convenient for you to get your favorite footwear at your doorstep.</p>
        <p>Whether you're looking for a classic pair for everyday wear or a statement piece for a special occasion, we've got you covered! Visit Shoe Store today and step into fashion with confidence.</p>
      </div>
      <div class="col-md-4">
        <img src="./images/info.jpg" alt="Shoe Store" class="img-fluid homepage-image-about">
      </div>
    </div>
  </div>
</section>

<!-- Why we Section with Image -->
<section class="bg-dark text-white homepage-three-icon-Section" id="features">
    <h3 class="text-center pt-4">Why Shoe Store.</h3>
    <div class="row text-center">
      <div class="homepage-features-box col-lg-4">
        <i class="fa-solid fa-circle-check fa-4x icons"></i>
        <h3>Customer Need</h3>
        <p>Shoe Store understand and provide custom size of shoes to their customer.</p>
      </div>

      <div class="homepage-features-box col-lg-4">
        <i class="fa-solid fa-heart fa-4x icons"></i>
        <h3>Happy Customer</h3>
        <p>Shoe store has the most happy client till date.</p>
      </div>

      <div class="homepage-features-box col-lg-4">
        <i class="fa-solid fa-shop fa-4x icons"></i>
        <h3>Stores</h3>
        <p>Shoe Store gives the largest number of shoes store.</p>
      </div>
    </div>
</section>



<!-- Featured Products -->
<section class="featured-products py-5">
  <div class="container">
    <h2 class="text-center mb-4">Featured Products</h2>
    <div class="row">
      <div class="col-md-4 mb-4">
        <div class="card">
          <img src="./images/men.jpg" class="card-img-top homepage-image-card" alt="Product 1">
          <div class="card-body">
            <h5 class="card-title">Men Shoes</h5>
            <p class="card-text">Visit our store or buy online.</p>
            <a href="#" class="btn btn-primary">Buy Now</a>
          </div>
        </div>
      </div>
      <div class="col-md-4 mb-4">
        <div class="card">
          <img src="./images/women.jpg" class="card-img-top homepage-image-card" alt="Product 2">
          <div class="card-body">
            <h5 class="card-title">Women Shoes</h5>
            <p class="card-text">Visit our store or buy online.</p>
            <a href="#" class="btn btn-primary">Buy Now</a>
          </div>
        </div>
      </div>
      <div class="col-md-4 mb-4">
        <div class="card">
          <img src="./images/kid.jpg" class="card-img-top homepage-image-card" alt="Product 3">
          <div class="card-body">
            <h5 class="card-title">Kids Shoes</h5>
            <p class="card-text">Visit our store or buy online.</p>
            <a href="#" class="btn btn-primary">Buy Now</a>
          </div>
        </div>
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
