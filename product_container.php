
<div class="row" id="productContainer">
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
