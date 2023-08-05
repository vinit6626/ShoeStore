<?php
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
require_once("db_conn.php");

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
    // Sanitize user inputs
    $brand = sanitizeInput($_POST["brand"]);
    $category = sanitizeInput($_POST["category"]);
    $shoeName = sanitizeInput($_POST["shoeName"]);
    $description = sanitizeInput($_POST["description"]);
    $gender = sanitizeInput($_POST["gender"]);
    $sizes = isset($_POST["size"]) ? $_POST["size"] : array(); // Handle checkboxes (multiple values)
    $price = sanitizeInput($_POST["price"]);
    $quantity = sanitizeInput($_POST["quantity"]);

    // Perform validation checks
    $errors = array();
    if (empty($brand)) {
        $errors['brand'] = "Please select a brand.";
    }

    if (empty($category)) {
        $errors['category'] = "Please select a category.";
    }

    if (empty($shoeName)) {
        $errors['shoeName'] = "Please enter the shoe name.";
    }

    if (empty($description)) {
        $errors['description'] = "Please enter the product description.";
    } elseif (str_word_count($description) > 150) {
        $errors['description'] = "Description should not exceed 150 words.";
    }

    if (empty($gender)) {
        $errors['gender'] = "Please select a gender.";
    }

    if (empty($sizes)) {
        $errors['sizes'] = "Please select at least one size.";
    }

    if (empty($price)) {
        $errors['price'] = "Please enter the shoe price.";
    } elseif (!is_numeric($price)) {
        $errors['price'] = "Please enter a valid numeric value for the price.";
    }

    if (empty($quantity)) {
        $errors['quantity'] = "Please enter the quantity.";
    } elseif (!ctype_digit($quantity)) {
        $errors['quantity'] = "Please enter a valid numeric value for the quantity.";
    }

    // Check if the file is uploaded successfully
    if (isset($_FILES['productImage']) && $_FILES['productImage']['error'] === UPLOAD_ERR_OK) {
      // Get the temporary file name
      $tmpFilePath = $_FILES['productImage']['tmp_name'];
  
      // Get the original file name and extension
      $originalFileName = $_FILES['productImage']['name'];
      $fileExtension = pathinfo($originalFileName, PATHINFO_EXTENSION);
  
      // Generate a new unique file name using timestamp
      $newFileName = time() . '.' . $fileExtension;
  
      // Specify the desired upload directory and the new file name
      $uploadDir = 'uploads/';
      $filePath = $uploadDir . $newFileName;
  
      // Move the uploaded file to the desired location
      if (!move_uploaded_file($tmpFilePath, $filePath)) {
          // File upload failed
          echo "Error: File upload failed.";
          exit;
      }
  }
  

    // If there are no validation errors, proceed with database insertion
    if (empty($errors)) {
        // Prepare and execute the database insertion query
        $stmt = "INSERT INTO shoe (b_id, c_id, shoe_name, product_description, gender, shoe_sizes, product_image, price, quantity) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $stmt);
        $sizesStr = implode(", ", $sizes); // Convert array to comma-separated string
        mysqli_stmt_bind_param($stmt, "iisssssds", $brand, $category, $shoeName, $description, $gender, $sizesStr, $filePath, $price, $quantity);

        $result = mysqli_stmt_execute($stmt);
        if ($result) {
            // Insertion successful
            $_SESSION['message'] = "Shoe details has been inserted successfully.";
            header("location: viewshoes.php"); 
            exit;
        } else {
            echo "Error: " . mysqli_error($conn);
        }
        mysqli_stmt_close($stmt);
    }
}

// Fetch brands and categories from the database
$stmt = "SELECT b_id, b_name FROM brands";
$result = mysqli_query($conn, $stmt);
$brands = mysqli_fetch_all($result, MYSQLI_ASSOC);

$stmt = "SELECT c_id, c_name FROM categories";
$result = mysqli_query($conn, $stmt);
$categories = mysqli_fetch_all($result, MYSQLI_ASSOC);

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

<div class="container mt-5 width40 mb-5">
    <h2 class="mb-4">Add New Shoe Product</h2>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">

    <!-- Brand selection -->
    <div class="mb-3">
    <label for="brand" class="form-label">Select Brand Name:</label>
    <select class="form-select <?php echo isset($errors['brand']) ? 'is-invalid' : ''; ?>" id="brand" name="brand">
        <option value="" selected>Select a brand</option>
        <?php foreach ($brands as $brand) : ?>
            <?php $selected = (isset($_POST['brand']) && $_POST['brand'] == $brand['b_id']) ? 'selected' : ''; ?>
            <option value="<?php echo $brand['b_id']; ?>" <?php echo $selected; ?>><?php echo $brand['b_name']; ?></option>
        <?php endforeach; ?>
    </select>
    <?php if (isset($errors['brand'])) : ?>
        <div class="invalid-feedback"><?php echo $errors['brand']; ?></div>
    <?php endif; ?>
</div>

<div class="mb-3">
    <label for="category" class="form-label">Select Category Name:</label>
    <select class="form-select <?php echo isset($errors['category']) ? 'is-invalid' : ''; ?>" id="category" name="category">
        <option value="" selected>Select a category</option>
        <?php foreach ($categories as $category) : ?>
            <?php $selected = (isset($_POST['category']) && $_POST['category'] == $category['c_id']) ? 'selected' : ''; ?>
            <option value="<?php echo $category['c_id']; ?>" <?php echo $selected; ?>><?php echo $category['c_name']; ?></option>
        <?php endforeach; ?>
    </select>
    <?php if (isset($errors['category'])) : ?>
        <div class="invalid-feedback"><?php echo $errors['category']; ?></div>
    <?php endif; ?>
</div>


    <!-- Shoe Name -->
    <div class="mb-3">
        <label for="shoeName" class="form-label">Shoe Name:</label>
        <input type="text" class="form-control  <?php echo isset($errors['shoeName']) ? 'is-invalid' : ''; ?>" id="shoeName" name="shoeName" placeholder="Shoe Name" value="<?php echo isset($_POST['shoeName']) ? $_POST['shoeName'] : ''; ?>">
        <?php if (isset($errors['shoeName'])) : ?>
            <div class="invalid-feedback"><?php echo $errors['shoeName']; ?></div>
        <?php endif; ?>
    </div>

    <!-- Product Description -->
    <div class="mb-3">
        <label for="description" class="form-label">Product Description:</label>
        <textarea class="form-control <?php echo isset($errors['description']) ? 'is-invalid' : ''; ?>" id="description" name="description" placeholder="Product Description"><?php echo isset($_POST['description']) ? $_POST['description'] : ''; ?></textarea>
        <?php if (isset($errors['description'])) : ?>
            <div class="invalid-feedback"><?php echo $errors['description']; ?></div>
        <?php endif; ?>
    </div>

    <!-- Gender selection -->
    <div class="mb-3">
    <label class="form-label">Gender:</label>
    <div class="form-check">
        <input type="radio" class="form-check-input <?php echo isset($errors['gender']) ? 'is-invalid' : ''; ?>" id="male" name="gender" value="male" <?php echo isset($_POST['gender']) && $_POST['gender'] === 'male' ? 'checked' : ''; ?>>
        <label class="form-check-label" for="male">Male</label>
    </div>
    <div class="form-check">
        <input type="radio" class="form-check-input <?php echo isset($errors['gender']) ? 'is-invalid' : ''; ?>" id="female" name="gender" value="female" <?php echo isset($_POST['gender']) && $_POST['gender'] === 'female' ? 'checked' : ''; ?>>
        <label class="form-check-label" for="female">Female</label>
    </div>
    <?php if (isset($errors['gender'])) : ?>
        <div class="invalid-feedback"><?php echo $errors['gender']; ?></div>
    <?php endif; ?>
</div>

<!-- Available Sizes -->
<div class="mb-3">
  <label class="form-label">Available Sizes:</label>
  <div class="form-check form-check-inline">
    <input type="checkbox" class="form-check-input" id="size7" name="size[]" value="7">
    <label class="form-check-label" for="size7">7</label>
  </div>
  <div class="form-check form-check-inline">
    <input type="checkbox" class="form-check-input" id="size8" name="size[]" value="8">
    <label class="form-check-label" for="size8">8</label>
  </div>
  <div class="form-check form-check-inline">
    <input type="checkbox" class="form-check-input" id="size9" name="size[]" value="9">
    <label class="form-check-label" for="size9">9</label>
  </div>
  <div class="form-check form-check-inline">
    <input type="checkbox" class="form-check-input" id="size10" name="size[]" value="10">
    <label class="form-check-label" for="size10">10</label>
  </div>
  <div class="form-check form-check-inline">
    <input type="checkbox" class="form-check-input" id="size11" name="size[]" value="11">
    <label class="form-check-label" for="size11">11</label>
  </div>



    <?php if (isset($errors['sizes'])) { ?>
        <div class="invalid-feedback"><?php echo $errors['sizes']; ?></div>
    <?php } ?>
</div>






<!-- Product Image -->
<div class="mb-3">
    <label for="productImage" class="form-label">Product Image:</label>
    <input type="file" class="form-control <?php echo isset($errors['productImage']) ? 'is-invalid' : ''; ?>" id="productImage" name="productImage" accept="image/*">
    <?php if (isset($errors['productImage'])) : ?>
        <div class="invalid-feedback"><?php echo $errors['productImage']; ?></div>
    <?php endif; ?>
</div>


    <!-- Price -->
    <div class="mb-3">
      <label for="price" class="form-label">Price:</label>
      <input type="text" class="form-control <?php echo isset($errors['price']) ? 'is-invalid' : ''; ?>" id="price" name="price" placeholder="Shoe Price" value="<?php echo isset($_POST['price']) ? $_POST['price'] : ''; ?>">
      <?php if (isset($errors['price'])) : ?>
          <div class="invalid-feedback"><?php echo $errors['price']; ?></div>
      <?php endif; ?>
    </div>

    <!-- Quantity -->
    <div class="mb-3">
      <label for="quantity" class="form-label">Quantity:</label>
      <input type="number" class="form-control <?php echo isset($errors['quantity']) ? 'is-invalid' : ''; ?>" id="quantity" name="quantity" placeholder="No of shoes" value="<?php echo isset($_POST['quantity']) ? $_POST['quantity'] : ''; ?>">
      <?php if (isset($errors['quantity'])) : ?>
          <div class="invalid-feedback"><?php echo $errors['quantity']; ?></div>
      <?php endif; ?>
    </div>

    <!-- Submit button -->
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
