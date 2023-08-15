<?php
require_once("db_conn.php");
session_start();
class CartManager {
  private $conn;

  public function __construct($conn) {
      $this->conn = $conn;
  }

  public function addToCart($account_id, $shoeId, $size, $quantity) {
      $insertQuery = "INSERT INTO cart (account_id, s_id, size, quantity) VALUES (?, ?, ?, ?)";
      $stmt = mysqli_prepare($this->conn, $insertQuery);
      mysqli_stmt_bind_param($stmt, "iisi", $account_id, $shoeId, $size, $quantity);

      if (mysqli_stmt_execute($stmt)) {
          return true;
      } else {
          return false;
      }
  }
}

class ShoeDetails {
  private $conn;

  public function __construct($conn) {
      $this->conn = $conn;
  }

  public function getShoeDetails($shoesId) {
      $stmt = "SELECT s_id,b.b_name AS brand_name, c.c_name AS category_name, s.shoe_name, s.gender, s.shoe_sizes, s.product_description, s.product_image, s.price, s.quantity
        FROM shoe s
        INNER JOIN brands b ON s.b_id = b.b_id
        INNER JOIN categories c ON s.c_id = c.c_id
        WHERE s.s_id = ?";

      $stmt = mysqli_prepare($this->conn, $stmt);
      mysqli_stmt_bind_param($stmt, "i", $shoesId);
      mysqli_stmt_execute($stmt);

      $result = mysqli_stmt_get_result($stmt);
      return mysqli_fetch_assoc($result);
  }
}

if (isset($_SESSION['username'])) {
  $cartManager = new CartManager($conn);
  $shoeDetails = new ShoeDetails($conn);

  if (isset($_GET['s_id'])) {
      $shoeId = $_GET['s_id'];
      $shoeData = $shoeDetails->getShoeDetails($shoeId);
      if ($shoeData) {
          $shoeSizesArray = explode(', ', $shoeData['shoe_sizes']);
      } else {
          echo "No shoe found with the provided ID.";
      }
  }

  if ($_SERVER["REQUEST_METHOD"] === "POST") {
      if (isset($_POST['s_id']) && isset($_POST['size']) && isset($_POST['quantity'])) {
          $shoeId = $_POST['s_id'];
          $size = $_POST['size'];
          $quantity = $_POST['quantity'];
          $account_id = $_POST['account_id'];

          if ($cartManager->addToCart($account_id, $shoeId, $size, $quantity)) {
              header("Location: cart.php");
              exit;
          } else {
              echo "Failed to add item to cart. Please try again later.";
          }
      } else {
          echo "Invalid data. Please provide all required information.";
      }
  }
} else {
  header("location: login.php");
  exit;
}
?>
<?php require_once('header.php'); ?>
<style>
 

  .quantity-container span {
    cursor: pointer;
    padding: 5px 10px;
  }

  .minus-btn {
    border-radius: 4px 0 0 4px;
  }

  .plus-btn {
    border-radius: 0 4px 4px 0;
  }
  input[type="number"] {
    -moz-appearance: textfield;
    appearance: textfield;
    margin: 0;
    padding: 0;
    text-align: center;
    width: 12%;
  }

  input[type="number"]::-webkit-inner-spin-button,
  input[type="number"]::-webkit-outer-spin-button {
    -webkit-appearance: none;
    margin: 0;
  }

</style>

<?php require_once('navbar.php'); ?>

<section class="hero-section custom-bg homepage-heading-section">
  <div class="container text-center homepage-heading-div">
    <h1 class="text-white">Welcome to Shoe Store</h1>
    <p class="text-white">Explore our latest collection of stylish shoes for every occasion.</p>
    
  </div>
</section>

<section class="item-page py-5">
<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
<input type="hidden" name="account_id" value="<?php echo $_SESSION['user_id']; ?>" >
<input type="hidden" name="s_id" value="<?php echo $shoeData['s_id']; ?>" >
  <h2 class="text-center"><b><?php echo $shoeData['brand_name']; ?></b></h2>
  <h4 class="text-center mb-5"><?php echo $shoeData['category_name']; ?></h4>
  <div class="container">
    <div class="row" style="justify-content: space-evenly;">
      <div class="col-md-4 text-center">
        <img src="<?php echo $shoeData['product_image']; ?>" alt="Product Image 1" class="item-image">
      </div>
      <div class="col-md-4">
        <h2 class="text-center"><?php echo $shoeData['shoe_name']; ?></h2>
        <p class="text-center">Gender: <?php echo $shoeData['gender']; ?></p>
        <p class="text-center">Price: $<?php echo $shoeData['price']; ?></p>
        <?php if ($shoeData['quantity'] > 0) { ?>
        <div class="text-center width60 mb-3"> 
            <label for="sizeSelect">Select size:</label>
            <select id="sizeSelect" name="size" class="form-select d-inline-block">
                <?php foreach ($shoeSizesArray as $size): ?>
                    <option value="<?php echo $size; ?>"><?php echo $size; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="text-center mb-3">
  <label class="form-label">Quantity:</label>
  <div class="input-group quantity-container d-inline-flex align-items-center justify-content-center">
      <span class="minus-btn btn btn-sm btn-secondary" onclick="decrementQuantity(<?php echo $shoeData['s_id']; ?>)">-</span>
      <input type="number" id="quantity-<?php echo $shoeData['s_id']; ?>" class="quantity-label mx-2" name="quantity" value="1" readonly>
      <span class="plus-btn btn btn-sm btn-secondary" onclick="incrementQuantity(<?php echo $shoeData['s_id']; ?>, <?php echo $shoeData['quantity']; ?>)">+</span>

</div>

</div>

        <input type="hidden" id="s_id" name="s_id" value="<?php echo $shoeData['s_id']; ?>">

        <div class="text-center">
          <input type="submit" class="btn btn-primary mb-3" onclick="addToCart()" value="Add to Cart"/>
        </div>
      </form>
      <?php }else{ ?>
  <h4 class="text-center text-danger" > This product is out of stock</h4>
  <?php } ?>
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
            <div class="accordion-body" style="width: 70%; margin: auto;">
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

<script>
   function decrementQuantity(shoesId) {
    var quantityInput = document.getElementById('quantity-' + shoesId);
    if (quantityInput) {
        var currentQuantity = parseInt(quantityInput.value);
        if (currentQuantity > 1) {
            quantityInput.value = currentQuantity - 1;
        }
    }
}

function incrementQuantity(shoesId, maxQuantity) {
    var quantityInput = document.getElementById('quantity-' + shoesId);
    if (quantityInput) {
        var currentQuantity = parseInt(quantityInput.value);
        if (currentQuantity < maxQuantity) {
            quantityInput.value = currentQuantity + 1;
        }
    }
}
</script>