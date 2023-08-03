<?php
require_once("db_conn.php");

$stmt = "SELECT s.s_id, s.shoe_name, s.product_image, s.shoe_sizes, s.gender, s.price, b.b_name as brand_name
         FROM shoe s
         INNER JOIN brands b ON s.b_id = b.b_id";

$result = mysqli_query($conn, $stmt);
$products = mysqli_fetch_all($result, MYSQLI_ASSOC);

?>

<?php require_once('header.php'); ?>
<?php require_once('navbar.php'); ?>

<section class="hero-section custom-bg homepage-heading-section">
  <div class="container text-center homepage-heading-div">
    <h1 class="text-white">Welcome to Shoe Store</h1>
    <p class="text-white">Explore our latest collection of stylish shoes for every occasion.</p>
  </div>
</section>

<section class="product-page py-5">
  <div class="container">
    <?php include_once("filter_section.php"); ?>
    <div class="row" id="productContainer">
      <!-- Products will be populated here -->
      <?php foreach ($products as $product): ?>
        <div class="col-md-4">
          <div class="card mb-4">
            <img src="<?php echo $product['product_image']; ?>" class="card-img-top" alt="<?php echo $product['shoe_name']; ?>" style="height: 550px;">
            <div class="card-body">
              <h5 class="card-title"><?php echo $product['shoe_name']; ?></h5>
              <p class="card-text"><?php echo $product['brand_name']; ?> | <?php echo ucfirst($product['gender']); ?> | <?php echo $product['shoe_sizes']; ?></p>
              <p class="card-text">Price: $<?php echo number_format($product['price'], 2); ?></p>
              <div class="text-center">
                <a href='item.php?s_id=<?php echo $product['s_id']; ?>' class='btn btn-primary'>View this product</a>
              </div>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<?php require_once('footer.php'); ?>
