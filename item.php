<?php
require_once("db_conn.php");

if (isset($_GET['s_id'])) {
  $shoesId = $_GET['s_id'];
  $stmt = "SELECT s_id,b.b_name AS brand_name, c.c_name AS category_name, s.shoe_name, s.gender, s.shoe_sizes, s.product_description, s.product_image, s.price, s.quantity
  FROM shoe s
  INNER JOIN brands b ON s.b_id = b.b_id
  INNER JOIN categories c ON s.c_id = c.c_id
  WHERE s.s_id = ?";
  
  $stmt = mysqli_prepare($conn, $stmt);
  mysqli_stmt_bind_param($stmt, "i", $shoesId);
  mysqli_stmt_execute($stmt);
  
  $result = mysqli_stmt_get_result($stmt);
  
  if ($shoeData = mysqli_fetch_assoc($result)) {
    $shoeSizesArray = explode(', ', $shoeData['shoe_sizes']);
   
  } else {
    echo "No shoe found with the provided ID.";
  }
}
?>

<?php require_once('header.php'); ?>
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

<h2 class="text-center"><b><?php echo $shoeData['brand_name']; ?></b></h2>
<h4 class="text-center mb-5"><?php echo $shoeData['category_name']; ?></h4>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-4 text-center">
        <img src="<?php echo $shoeData['product_image']; ?>" alt="Product Image 1" class="item-image">
      </div>
      <div class="col-md-4">
        <h2 class="text-center"><?php echo $shoeData['shoe_name']; ?></h2>
        <p class="text-center">Gender: <?php echo $shoeData['gender']; ?></p>
        <p class="text-center">Price: $<?php echo $shoeData['price']; ?></p>
        <div class="text-center width60 mb-3"> 
            <label for="sizeSelect">Select size:</label>
            <select id="sizeSelect" class="form-select d-inline-block">
                <?php foreach ($shoeSizesArray as $size): ?>
                    <option value="<?php echo $size; ?>"><?php echo $size; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="text-center">
          <button class="btn btn-primary mb-3">Add to Cart</button>
        </div>
        <div>
          <h3 class="text-center">Description</h3>
          <p class="text-center"> <?php echo $shoeData['product_description']; ?></p>
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
<?php require_once('footer.php'); ?>
