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

<!-- Item Page -->
<section class="item-page py-5">

<h2 class="text-center mb-5"><b>Brand Name</b></h2>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-4 text-center">
        <img src="./images/1.jpg" alt="Product Image 1" class="item-image">
      </div>
      <div class="col-md-4">
        <h2 class="text-center">Product Name</h2>
        <p class="text-center">Gender: Men</p>
        <p class="text-center">Price: $99.99</p>
        <div class="text-center width60 mb-3"> <!-- Add 'text-center' class here -->
          <p class="d-inline-block">Size:</p> <!-- Use 'd-inline-block' class to display in the same line -->
          <label for="sizeSelect">Select size:</label>
            <select id="sizeSelect" class="form-select d-inline-block">
                <option value="s">S</option>
                <option value="m">M</option>
                <option value="l">L</option>
            </select>
        </div>
        <div class="text-center">
          <button class="btn btn-primary mb-3">Add to Cart</button>
        </div>
        <div>
          <h3 class="text-center">Description</h3>
          <p class="text-center">Description of product.</p>
        </div>
        
        <div class="accordion-item mt-4 text-center"> 
          <h2 class="accordion-header center" id="deliveryHeading">
            <button class="accordion-button collapsed delivery-button" type="button" data-bs-toggle="collapse" data-bs-target="#deliveryCollapse" aria-expanded="false" aria-controls="deliveryCollapse">
              <h5>Delivery Policy</h5>
            </button>
          </h2>
          <div id="deliveryCollapse" class="accordion-collapse collapse mt-2" aria-labelledby="deliveryHeading" data-bs-parent="#faqAccordion">
            <div class="accordion-body">
            <p>Free delivery free across country.</p>
            <p>You can return your order for any reason, free of charge, within 30 days.</p>
            </div>
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
