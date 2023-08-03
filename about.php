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

<!-- About Us Section -->
<section class="about-us-section py-5">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <h2 class="mb-4 text-center">About Us</h2>
        <p>
          Shoe Store is your ultimate destination for trendy and stylish footwear. We take pride in offering a diverse collection of shoes to match every occasion and outfit. Whether you're looking for comfortable sneakers, elegant heels, or durable boots, we have got you covered.
        </p>
        <p>
          Our team of dedicated designers and craftsmen ensure that each pair of shoes is crafted with precision and attention to detail. We believe in delivering the highest quality products to our customers, and our passion for footwear reflects in our offerings.
        </p>
        <p>
          At Shoe Store, we value our customers and strive to provide an enjoyable shopping experience. Our customer support team is always ready to assist you with any inquiries or concerns you may have.
        </p>
        <p>
          Thank you for choosing Shoe Store for all your footwear needs. We look forward to serving you and being a part of your fashion journey.
        </p>
      </div>
    </div>
  </div>
</section>

<!-- About Us Section -->
<section class="about-us-section py-5">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-12">
        <h2 class="text-center">Our Team</h2>
      </div>
    </div>
    <div class="row justify-content-center">
      <div class="col-md-6  mb-4 ">
        <div class="staff-card">
          <img src="./images/vinit.png" class="staff-photo" alt="Staff 1">
          <h4>Vinit Dabhi</h4>
          <p class="text-muted">Founder of Shoe Store</p>
          <p class="text-muted">Kitchener, ON</p>
        </div>
      </div>
      <div class="col-md-6  mb-4">
        <div class="staff-card">
          <img src="./images/tim.png" class="staff-photo" alt="Staff 2">
          <h4>Tim Cook</h4>
          <p class="text-muted">CEO of Shoe Store</p>
          <p class="text-muted">Kitchener, ON</p>
        </div>
      </div>
      <div class="col-md-6 mb-4">
        <div class="staff-card">
          <img src="./images/jeff.png" class="staff-photo" alt="Staff 2">
          <h4>Jeff Bezos</h4>
          <p class="text-muted">Logistic Manager</p>
          <p class="text-muted">Kitchener, ON</p>
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
