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


<!-- FAQ Section -->
<section class="faq-section py-5">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <h2 class="text-center">Frequently Asked Questions</h2>
      </div>
    </div>
    <div class="row">
      <div class="col-md-12">
        <div class="accordion" id="faqAccordion">
          <div class="accordion-item">
            <h2 class="accordion-header" id="faqHeading1">
              <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#faqCollapse1" aria-expanded="true" aria-controls="faqCollapse1">
                What payment methods do you accept?
              </button>
            </h2>
            <div id="faqCollapse1" class="accordion-collapse collapse show" aria-labelledby="faqHeading1" data-bs-parent="#faqAccordion">
              <div class="accordion-body">
                We accept all major credit cards, including Visa, Mastercard, and American Express. Additionally, we also support payments via PayPal and Apple Pay.
              </div>
            </div>
          </div>
          <div class="accordion-item">
            <h2 class="accordion-header" id="faqHeading2">
              <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faqCollapse2" aria-expanded="false" aria-controls="faqCollapse2">
                What is your return policy?
              </button>
            </h2>
            <div id="faqCollapse2" class="accordion-collapse collapse" aria-labelledby="faqHeading2" data-bs-parent="#faqAccordion">
              <div class="accordion-body">
                We offer a hassle-free 30-day return policy. If you are not satisfied with your purchase, you can return the item within 30 days of delivery for a full refund or exchange.
              </div>
            </div>
          </div>
          <div class="accordion-item">
            <h2 class="accordion-header" id="faqHeading3">
              <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faqCollapse3" aria-expanded="false" aria-controls="faqCollapse3">
                Do you offer international shipping?
              </button>
            </h2>
            <div id="faqCollapse3" class="accordion-collapse collapse" aria-labelledby="faqHeading3" data-bs-parent="#faqAccordion">
              <div class="accordion-body">
                Yes, we offer international shipping to most countries. Shipping fees and delivery times may vary based on the destination. Please check our shipping page for more information.
              </div>
            </div>
          </div>
          <div class="accordion-item">
            <h2 class="accordion-header" id="faqHeading4">
              <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faqCollapse4" aria-expanded="false" aria-controls="faqCollapse4">
                How can I track my order?
              </button>
            </h2>
            <div id="faqCollapse4" class="accordion-collapse collapse" aria-labelledby="faqHeading4" data-bs-parent="#faqAccordion">
              <div class="accordion-body">
                Once your order is shipped, we will send you a tracking number via email. You can use this tracking number to track the status of your order on our website or through the carrier's website.
              </div>
            </div>
          </div>
          <div class="accordion-item">
            <h2 class="accordion-header" id="faqHeading5">
              <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faqCollapse5" aria-expanded="false" aria-controls="faqCollapse5">
                Do you offer gift wrapping services?
              </button>
            </h2>
            <div id="faqCollapse5" class="accordion-collapse collapse" aria-labelledby="faqHeading5" data-bs-parent="#faqAccordion">
              <div class="accordion-body">
                Yes, we offer gift wrapping services for an additional fee. During the checkout process, you can select the gift wrapping option and add a personalized message for the recipient.
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>


<hr class="line"/>

<!-- Contact Details Section -->
<section class="contact-details-section py-5 text-center">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-4 contact-details-content">
        <h3>Contact Details</h3>
        <p><i class="fa-solid fa-envelope"></i> Email: info@shoestore.com</p>
        <p><i class="fa-solid fa-phone"></i> Phone: +1 (123) 456-7890</p>
        <p><i class="fa-solid fa-map-marker"></i> Address: 108 University ave, ON, Canada</p>
      </div>
    </div>
  </div>
</section>

<hr class="line"/>

<!-- Contact Details Section -->
<section class="contact-details-section py-5 mb-5">
  <div class="container">
    <div class="row">
      <div class="col-md-12 text-center"> 
      <h3 class="mb-3">Visit our store</h3>

        <div class="map-container">
          <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2895.101593608705!2d-80.52108322440726!3d43.47935016365852!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x882bf31d0cec9491%3A0x8bf5f60c306d2207!2sConestoga%20College%20Waterloo%20Campus!5e0!3m2!1sen!2sca!4v1690509657815!5m2!1sen!2sca" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade" title="map" aria-label="map"></iframe>
        </div>
      </div>
    </div>
  </div>
</section>

<hr class="line"/>

<!-- Contact Form Section -->
<section class="contact-form-section py-5">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-6">
        <h2 class="text-center mb-4">Contact Us</h2>
        <form>
          <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" class="form-control" id="name" name="name" placeholder="Name">
          </div>
          <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" placeholder="Email">
          </div>
          <div class="mb-3">
            <label for="phone" class="form-label">Phone Number</label>
            <input type="tel" class="form-control" id="phone" name="phone" placeholder="Phone">
          </div>
          <div class="mb-3">
            <label for="message" class="form-label">Message</label>
            <textarea class="form-control" id="message" name="message" rows="5" placeholder="Message"></textarea>
          </div>
          <div class="text-center">
            <button type="submit" class="btn btn-primary">Submit</button>
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
