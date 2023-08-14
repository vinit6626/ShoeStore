<?php
// error_reporting(E_ALL);
// ini_set('display_errors', 1);

require_once("db_conn.php");

// Initialize error messages array
$errors = array();

function sanitizeInput($input){
  $input = str_replace(['(',')','"', ';'], '', $input);
  $input = strip_tags($input);
  $input = trim($input);
  $input = htmlentities($input, ENT_QUOTES, 'UTF-8');
  $input = htmlspecialchars($input);
  return $input;
}
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Retrieve form data
    $name = sanitizeInput($_POST["name"]);
    $email = sanitizeInput($_POST["email"]);
    $phone = sanitizeInput($_POST["phone"]);
    $message = sanitizeInput($_POST["message"]);

    if (empty($errors)) {
        $stmt = "INSERT INTO contact_us (name, email, phone, message) VALUES (?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $stmt);
        mysqli_stmt_bind_param($stmt, "ssss", $name, $email, $phone, $message);

        $result = mysqli_stmt_execute($stmt);
        if ($result) {
            echo "<div class='alert alert-success alert-dismissible fade show' role='alert' style='margin-bottom: 0px;'>Your message sent to ShoeStore admin.<button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button></div>";
            // header("location: contact.php");
            // exit;
        } else {
            // echo "Error: " . $stmt->error;
            echo "<div class='alert alert-danger' role='alert' style='margin-bottom: 0px;'>Database error.</div>";
            // header("location: contact.php");
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
        <form method="POST" action="<?php echo $_SERVER['PHP_SELF'];?>" id="contact-form">
          <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" class="form-control" id="name" name="name" placeholder="Name">
            <span class="text-danger" id="name-error"><?php echo isset($errors['name']) ? $errors['name'] : ''; ?></span>
          </div>
          <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="text" class="form-control" id="email" name="email" placeholder="Email">
            <span class="text-danger" id="email-error"><?php echo isset($errors['email']) ? $errors['email'] : ''; ?></span>
          </div>
          <div class="mb-3">
            <label for="phone" class="form-label">Phone Number</label>
            <input type="tel" class="form-control" id="phone" name="phone" placeholder="Phone">
            <span class="text-danger" id="phone-error"><?php echo isset($errors['phone']) ? $errors['phone'] : ''; ?></span>
          </div>
          <div class="mb-3">
            <label for="message" class="form-label">Message</label>
            <textarea class="form-control" id="message" name="message" rows="5" placeholder="Message" maxlength="200"></textarea>
            <span id="char-count" style="float: right;">0/200</span>
            <span class="text-danger" id="message-error"><?php echo isset($errors['message']) ? $errors['message'] : ''; ?></span>
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

<!-- JavaScript Section -->
<script>
  const form = document.getElementById("contact-form");

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
    const name = document.getElementById("name").value.trim();
    const email = document.getElementById("email").value.trim();
    const phone = document.getElementById("phone").value.trim();
    const message = document.getElementById("message").value.trim();

    // Clear previous error messages
    document.getElementById("name-error").textContent = "";
    document.getElementById("email-error").textContent = "";
    document.getElementById("phone-error").textContent = "";
    document.getElementById("message-error").textContent = "";

    // Validate name
    if (name === "") {
      document.getElementById("name-error").textContent = "Name is required.";
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

    // Validate phone
    if (phone === "") {
      document.getElementById("phone-error").textContent = "Phone number is required.";
      isValid = false;
    }else if (!phoneIsValid(phone)) {
      document.getElementById("phone-error").textContent = "Phone number should be 10 digit only.";
      isValid = false;
    }

     // Validate message
     if (message === "") {
      document.getElementById("message-error").textContent = "Message is required.";
      isValid = false;
    }
    return isValid;
  }
  function emailIsValid(email) {
    return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
  }
  function phoneIsValid(phone) {
  const numericPhone = phone.replace(/\D/g, '');
  return /^\d{10}$/.test(numericPhone);
}

</script>

<script>
    // Add an event listener to the textarea for input events
    const messageInput = document.getElementById("message");
    messageInput.addEventListener("input", updateCharCount);

    function updateCharCount() {
      const message = messageInput.value;
      const charCountSpan = document.getElementById("char-count");
      const charCount = message.length;
      
      // Update the character count display
      charCountSpan.textContent = charCount + "/200";
    }
  </script>