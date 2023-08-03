<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once("db_conn.php");

// Fetch brands and categories from the database
$stmt = "SELECT b_id, b_name FROM brands";
$result = mysqli_query($conn, $stmt);
$brands = mysqli_fetch_all($result, MYSQLI_ASSOC);

$stmt = "SELECT c_id, c_name FROM categories";
$result = mysqli_query($conn, $stmt);
$categories = mysqli_fetch_all($result, MYSQLI_ASSOC);


if (isset($_GET['s_id'])) {
    $shoesId = $_GET['s_id'];
    $_SESSION['shoes_id'] = $shoesId;
    $stmt = "SELECT * FROM shoe WHERE s_id = $shoesId";
    $result = mysqli_query($conn, $stmt);
    $shoeData = mysqli_fetch_assoc($result);
}
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $shoeName = $_POST['shoeName'];
        $description = $_POST['description'];
        $gender = $_POST['gender'];
        $price = $_POST['price'];
        $quantity = $_POST['quantity'];
        $shoesId = $_SESSION['shoes_id'];

           
            if ($_FILES['productImage']['name']) {
                $stmt = "SELECT * FROM shoe WHERE s_id = $shoesId";
                $result = mysqli_query($conn, $stmt);
                $shoeData = mysqli_fetch_assoc($result);
                unlink($shoeData['product_image']);

                
                $timestamp = time(); 
                $imageName = $timestamp . '_' . $_FILES['productImage']['name']; 

                $imagePath = "uploads/" . $imageName;
                move_uploaded_file($_FILES['productImage']['tmp_name'], $imagePath);

                $stmt = "UPDATE shoe SET product_image = ? WHERE s_id = ?";
                $stmt = mysqli_prepare($conn, $stmt);
                mysqli_stmt_bind_param($stmt, "si", $imagePath, $shoesId);
                mysqli_stmt_execute($stmt);
                if (mysqli_stmt_error($stmt)) {
                    $errors[] = "Error occurred during image update: " . mysqli_stmt_error($stmt);
                }
    
                mysqli_stmt_close($stmt);
            }

            $brandId = $_POST['brand'];
            $categoryId = $_POST['category'];
            $shoeSizes = implode(', ', $_POST['size']);

            
            $stmt = "UPDATE shoe SET 
                        b_id = ?,
                        c_id = ?,
                        shoe_name = ?,
                        product_description = ?,
                        gender = ?,
                        shoe_sizes = ?,
                        price = ?,
                        quantity = ?
                    WHERE s_id = ?";
        
            $stmt = mysqli_prepare($conn, $stmt);
            mysqli_stmt_bind_param($stmt, "iissssdii", $brandId, $categoryId, $shoeName, $description, $gender, $shoeSizes, $price, $quantity, $shoesId);
            mysqli_stmt_execute($stmt);

            // Check for errors
            if (mysqli_stmt_error($stmt)) {
                $errors[] = "Error occurred during the update: " . mysqli_stmt_error($stmt);
            }

            mysqli_stmt_close($stmt);

            if (empty($errors)) {
                header("Location: viewshoes.php");
                exit();
            }
    }


?>
<?php require_once('header.php'); ?>

<?php require_once('navbar.php'); ?>

<div class="container mt-5 width40 mb-5">
    <h2 class="mb-4">Add New Shoe Product</h2>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">

   <!-- Brand selection -->
<div class="mb-3">
    <label for="brand" class="form-label">Select Brand Name:</label>
    <select class="form-select" id="brand" name="brand">
        <option value="" selected>Select a brand</option>
        <?php foreach ($brands as $brand) : ?>
            <option value="<?php echo $brand['b_id']; ?>" <?php echo ($shoeData['b_id'] == $brand['b_id']) ? 'selected' : ''; ?>><?php echo $brand['b_name']; ?></option>
        <?php endforeach; ?>
    </select>
</div>

<!-- Category selection -->
<div class="mb-3">
    <label for="category" class="form-label">Select Category Name:</label>
    <select class="form-select" id="category" name="category">
        <option value="" selected>Select a category</option>
        <?php foreach ($categories as $category) : ?>
            <option value="<?php echo $category['c_id']; ?>" <?php echo ($shoeData['c_id'] == $category['c_id']) ? 'selected' : ''; ?>><?php echo $category['c_name']; ?></option>
        <?php endforeach; ?>
    </select>
</div>

<!-- Shoe Name -->
<div class="mb-3">
    <label for="shoeName" class="form-label">Shoe Name:</label>
    <input type="text" class="form-control" id="shoeName" name="shoeName" placeholder="Shoe Name" value="<?php echo $shoeData['shoe_name']; ?>">
</div>

<!-- Product Description -->
<div class="mb-3">
    <label for="description" class="form-label">Product Description:</label>
    <textarea class="form-control" id="description" name="description" placeholder="Product Description"><?php echo $shoeData['product_description']; ?></textarea>
</div>

    <!-- Gender selection -->
<div class="mb-3">
    <label class="form-label">Gender:</label>
    <div class="form-check">
        <input type="radio" class="form-check-input" id="male" name="gender" value="male" <?php echo ($shoeData['gender'] === 'male') ? 'checked' : ''; ?>>
        <label class="form-check-label" for="male">Male</label>
    </div>
    <div class="form-check">
        <input type="radio" class="form-check-input" id="female" name="gender" value="female" <?php echo ($shoeData['gender'] === 'female') ? 'checked' : ''; ?>>
        <label class="form-check-label" for="female">Female</label>
    </div>
</div>

<!-- Available Sizes -->
<div class="mb-3">
    <label class="form-label">Available Sizes:</label>
    <div class="form-check form-check-inline">
        <input type="checkbox" class="form-check-input" id="size7" name="size[]" value="7" <?php echo (in_array('7', explode(',', $shoeData['shoe_sizes']))) ? 'checked' : ''; ?>>
        <label class="form-check-label" for="size7">7</label>
    </div>
    <div class="form-check form-check-inline">
        <input type="checkbox" class="form-check-input" id="size8" name="size[]" value="8" <?php echo (in_array('8', explode(',', $shoeData['shoe_sizes']))) ? 'checked' : ''; ?>>
        <label class="form-check-label" for="size8">8</label>
    </div>
    <div class="form-check form-check-inline">
        <input type="checkbox" class="form-check-input" id="size9" name="size[]" value="9" <?php echo (in_array('9', explode(',', $shoeData['shoe_sizes']))) ? 'checked' : ''; ?>>
        <label class="form-check-label" for="size9">9</label>
    </div>
    <div class="form-check form-check-inline">
        <input type="checkbox" class="form-check-input" id="size10" name="size[]" value="10" <?php echo (in_array('10', explode(',', $shoeData['shoe_sizes']))) ? 'checked' : ''; ?>>
        <label class="form-check-label" for="size10">10</label>
    </div>
    <div class="form-check form-check-inline">
        <input type="checkbox" class="form-check-input" id="size11" name="size[]" value="11" <?php echo (in_array('11', explode(',', $shoeData['shoe_sizes']))) ? 'checked' : ''; ?>>
        <label class="form-check-label" for="size11">11</label>
    </div>
</div>
    <div class="mb-3 ">
        <label for="productImage" class="form-label">Current Uploaded Image:</label>
        <div>
        <img src="<?php echo $shoeData['product_image']; ?>" alt="Product Image" width="200"></td>
        <div>
    </div>
<!-- Product Image -->
<div class="mb-3 mt-3">
    <label for="productImage" class="form-label">Product New Image:</label>
    <input type="file" class="form-control" id="productImage" name="productImage" accept="image/*">
    <!-- You can leave the value attribute empty for file inputs as they cannot be pre-filled -->
</div>

<!-- Price -->
<div class="mb-3">
    <label for="price" class="form-label">Price:</label>
    <input type="text" class="form-control" name="price" placeholder="Shoe Price" value="<?php echo $shoeData['price']; ?>">
</div>

<!-- Quantity -->
<div class="mb-3">
    <label for="quantity" class="form-label">Quantity:</label>
    <input type="number" class="form-control" id="quantity" name="quantity" placeholder="No of shoes" value="<?php echo $shoeData['quantity']; ?>">
</div>


    <!-- Submit button -->
    <button type="submit" class="btn btn-primary">Submit</button>
</form>

  </div>
        </div>
        </div>



<!-- Footer Section -->
<?php require_once('footer.php'); ?>
