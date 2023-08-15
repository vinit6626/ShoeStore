<?php
require_once("db_conn.php");
class Database {
  private $conn;

  public function __construct($conn) {
      $this->conn = $conn;
  }
  public function fetchBrands() {
      $brandsQuery = "SELECT b_id, b_name FROM brands";
      $brandsResult = mysqli_query($this->conn, $brandsQuery);
      return mysqli_fetch_all($brandsResult, MYSQLI_ASSOC);
  }
  public function fetchCategories() {
      $categoriesQuery = "SELECT c_id, c_name FROM categories";
      $categoriesResult = mysqli_query($this->conn, $categoriesQuery);
      return mysqli_fetch_all($categoriesResult, MYSQLI_ASSOC);
  }
}

$database = new Database($conn);
$brands = $database->fetchBrands();
$categories = $database->fetchCategories();

?>
<div class="container mb-4">
  <div class="row justify-content-center align-items-center">
    <div class="col-md-12">
      <h3 class="text-center mb-4">Filter</h3>
    </div>
    <div class="col-md-2">
      <label for="brand">Brand:</label>
      <select class="form-select" id="brand">
        <option value="all">All</option>
        <?php foreach ($brands as $brand): ?>
          <option value="<?php echo $brand['b_id']; ?>"><?php echo $brand['b_name']; ?></option>
        <?php endforeach; ?>
      </select>
    </div>

    <div class="col-md-2">
  <label for="category">Category:</label>
  <select class="form-select" id="category">
    <option value="all">All</option>
    <?php foreach ($categories as $category): ?>
      <option value="<?php echo $category['c_id']; ?>"><?php echo $category['c_name']; ?></option>
    <?php endforeach; ?>
  </select>
</div>
<div class="col-md-2">
  <label for="sortPrice">Price:</label>
  <select class="form-select" id="sortPrice">
    <option value="low_to_high">Low to High</option>
    <option value="high_to_low">High to Low</option>
  </select>
</div>
    <div class="col-md-2">
      <button type="button" class="btn btn-primary btn-block" onclick="applyFilters()">Apply Filters</button>
    </div>
  </div>
</div>


<script>
function applyFilters() {
  const brandValue = document.getElementById('brand').value;
  const categoryValue = document.getElementById('category').value;
  const sortPriceValue = document.getElementById('sortPrice').value;

  const xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState === 4 && this.status === 200) {
      const products = JSON.parse(this.responseText);
      displayFilteredData(products);
    }
  };

  xhttp.open('GET', `filter.php?brand=${brandValue}&category=${categoryValue}&sortPrice=${sortPriceValue}`, true);
  xhttp.send();
}


function displayFilteredData(products) {
  const productContainer = document.getElementById('productContainer');
  productContainer.innerHTML = ''; 
  if (products.length === 0) {
    const noResultsHTML = `
      <div class="col-md-12 text-center">
        <h3>No results found.</h3>
      </div>
    `;
    productContainer.insertAdjacentHTML('beforeend', noResultsHTML);
  } else {
    products.forEach(product => {
      const cardHTML = `
        <div class="col-md-4">
          <div class="card mb-4">
            <img src="${product.product_image}" class="card-img-top" alt="${product.shoe_name}" style="height: 550px;">
            <div class="card-body">
              <h5 class="card-title">${product.shoe_name}</h5>
              <p class="card-text">${product.brand_name} | ${product.gender} | ${product.shoe_sizes}</p>
              <p class="card-text">Price: $${parseFloat(product.price).toFixed(2)}</p>
              <div class="text-center">
                <a href='item.php?s_id=${product.s_id}' class='btn btn-primary'>View this product</a>
              </div>
            </div>
          </div>
        </div>
      `;

      productContainer.insertAdjacentHTML('beforeend', cardHTML);
    });
  }
}

</script>
