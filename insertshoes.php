<?php
session_start();
require_once("db_conn.php");

class Database {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function insertShoe($brand, $category, $shoeName, $description, $gender, $sizes, $filePath, $price, $quantity) {
        $sizesStr = implode(", ", $sizes);

        $stmt = "INSERT INTO shoe (b_id, c_id, shoe_name, product_description, gender, shoe_sizes, product_image, price, quantity) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($this->conn, $stmt);
        mysqli_stmt_bind_param($stmt, "iisssssds", $brand, $category, $shoeName, $description, $gender, $sizesStr, $filePath, $price, $quantity);

        return mysqli_stmt_execute($stmt);
    }
}

if (isset($_SESSION['username'])) {
    function sanitizeInput($input){
        $input = str_replace(['(',')','"', ';'], '', $input);
        $input = strip_tags($input);
        $input = trim($input);
        $input = htmlentities($input, ENT_QUOTES, 'UTF-8');
        $input = htmlspecialchars($input);
        return $input;
    }

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $brand = sanitizeInput($_POST["brand"]);
        $category = sanitizeInput($_POST["category"]);
        $shoeName = sanitizeInput($_POST["shoeName"]);
        $description = sanitizeInput($_POST["description"]);
        $gender = sanitizeInput($_POST["gender"]);
        $sizes = isset($_POST["size"]) ? $_POST["size"] : array(); 
        $price = sanitizeInput($_POST["price"]);
        $quantity = sanitizeInput($_POST["quantity"]);
    
        $database = new Database($conn);

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
    
        if (isset($_FILES['productImage']) && $_FILES['productImage']['error'] === UPLOAD_ERR_OK) {
          $tmpFilePath = $_FILES['productImage']['tmp_name'];
      
          $originalFileName = $_FILES['productImage']['name'];
          $fileExtension = pathinfo($originalFileName, PATHINFO_EXTENSION);
      
          $newFileName = time() . '.' . $fileExtension;
          $uploadDir = 'uploads/';
          $filePath = $uploadDir . $newFileName;
          if (!move_uploaded_file($tmpFilePath, $filePath)) {
              echo "Error: File upload failed.";
              exit;
          }
      }
        if (empty($errors)) {
            $result = $database->insertShoe($brand, $category, $shoeName, $description, $gender, $sizes, $filePath, $price, $quantity);
            if ($result) {
                $_SESSION['message'] = "Shoe details have been inserted successfully.";
                header("location: viewshoes.php"); 
                exit;
            } else {
                echo "Error: " . mysqli_error($conn);
            }
        }
    }

$stmt = "SELECT b_id, b_name FROM brands";
$result = mysqli_query($conn, $stmt);
$brands = mysqli_fetch_all($result, MYSQLI_ASSOC);

$stmt = "SELECT c_id, c_name FROM categories";
$result = mysqli_query($conn, $stmt);
$categories = mysqli_fetch_all($result, MYSQLI_ASSOC);

} else {
    header("location: login.php");
    exit;
}
?>
<?php require_once('header.php'); ?>
<?php require_once('navbar.php'); ?>

<div class="container mt-5 width40 mb-5">
    <h2 class="mb-4">Add New Shoe Product</h2>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">

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

    <div class="mb-3">
        <label for="shoeName" class="form-label">Shoe Name:</label>
        <input type="text" class="form-control  <?php echo isset($errors['shoeName']) ? 'is-invalid' : ''; ?>" id="shoeName" name="shoeName" placeholder="Shoe Name" value="<?php echo isset($_POST['shoeName']) ? $_POST['shoeName'] : ''; ?>">
        <?php if (isset($errors['shoeName'])) : ?>
            <div class="invalid-feedback"><?php echo $errors['shoeName']; ?></div>
        <?php endif; ?>
    </div>

    <div class="mb-3">
        <label for="description" class="form-label">Product Description:</label>
        <textarea class="form-control <?php echo isset($errors['description']) ? 'is-invalid' : ''; ?>" id="description" name="description" placeholder="Product Description"><?php echo isset($_POST['description']) ? $_POST['description'] : ''; ?></textarea>
        <?php if (isset($errors['description'])) : ?>
            <div class="invalid-feedback"><?php echo $errors['description']; ?></div>
        <?php endif; ?>
    </div>

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

<div class="mb-3">
    <label for="productImage" class="form-label">Product Image:</label>
    <input type="file" class="form-control <?php echo isset($errors['productImage']) ? 'is-invalid' : ''; ?>" id="productImage" name="productImage" accept="image/*">
    <?php if (isset($errors['productImage'])) : ?>
        <div class="invalid-feedback"><?php echo $errors['productImage']; ?></div>
    <?php endif; ?>
</div>


    <div class="mb-3">
      <label for="price" class="form-label">Price:</label>
      <input type="text" class="form-control <?php echo isset($errors['price']) ? 'is-invalid' : ''; ?>" id="price" name="price" placeholder="Shoe Price" value="<?php echo isset($_POST['price']) ? $_POST['price'] : ''; ?>">
      <?php if (isset($errors['price'])) : ?>
          <div class="invalid-feedback"><?php echo $errors['price']; ?></div>
      <?php endif; ?>
    </div>

    <div class="mb-3">
      <label for="quantity" class="form-label">Quantity:</label>
      <input type="number" class="form-control <?php echo isset($errors['quantity']) ? 'is-invalid' : ''; ?>" id="quantity" name="quantity" placeholder="No of shoes" value="<?php echo isset($_POST['quantity']) ? $_POST['quantity'] : ''; ?>">
      <?php if (isset($errors['quantity'])) : ?>
          <div class="invalid-feedback"><?php echo $errors['quantity']; ?></div>
      <?php endif; ?>
    </div>

    <button type="submit" class="btn btn-primary">Submit</button>
</form>

</div>

<?php require_once('footer.php'); ?>