<?php
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);

require_once("db_conn.php");

$stmt = "SELECT s.s_id, s.shoe_name, s.product_image, s.shoe_sizes,  s.gender, s.price, b.b_name as brand_name
         FROM shoe s
         INNER JOIN brands b ON s.b_id = b.b_id";

$result = mysqli_query($conn, $stmt);
$products = mysqli_fetch_all($result, MYSQLI_ASSOC);
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
<!-- Product Page with Filters and Sorting -->
<section class="product-page py-5">
  <div class="container">
    <!-- Filters Section -->
    <div class="row mb-4">
      <div class="col-md-4">
        <label for="gender">Gender:</label>
        <select class="form-select" id="gender">
          <option value="all">All</option>
          <option value="men">Men</option>
          <option value="women">Women</option>
          <option value="kids">Kids</option>
        </select>
      </div>
      <div class="col-md-4">
        <label for="brand">Brand:</label>
        <select class="form-select" id="brand">
          <option value="all">All</option>
          <option value="nike">Nike</option>
          <option value="adidas">Adidas</option>
          <option value="puma">Puma</option>
        </select>
      </div>
      <div class="col-md-4">
        <hr class="d-md-none"> <!-- Vertical line visible on smaller devices -->
        <label for="sort">Sort By:</label>
        <select class="form-select" id="sort">
          <option value="az">Name (A to Z)</option>
          <option value="za">Name (Z to A)</option>
          <option value="price_low_high">Price (Low to High)</option>
          <option value="price_high_low">Price (High to Low)</option>
        </select>
      </div>
    </div>
    
    <!-- Product List -->
    <div class="row">
    <?php foreach ($products as $product): ?>
        <div class="col-md-4">
            <div class="card mb-4">
                <img src="<?php echo $product['product_image']; ?>" class="card-img-top" alt="<?php echo $product['shoe_name']; ?>" style="height: 550px;">
                <div class="card-body">
                    <h5 class="card-title"><?php echo $product['shoe_name']; ?></h5>
                    <p class="card-text"><?php echo $product['brand_name']; ?> | <?php echo ucfirst($product['gender']); ?> | <?php echo $product['shoe_sizes']; ?> </p>
                    <p class="card-text">Price: $<?php echo number_format($product['price'], 2); ?></p>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>

  </div>
</section>

<?php require_once('footer.php'); ?>
