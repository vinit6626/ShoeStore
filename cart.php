<?php

// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
session_start();
include "invoicePDF.php";
require_once("db_conn.php");


if ($_SERVER["REQUEST_METHOD"] === "POST") {
$account_id = $_POST["account_id"];
$s_ids = $_POST["s_id"];
$full_name = $_POST["full_name"];
$address = $_POST["address"];
$zipcode = $_POST["zipcode"];
$province = $_POST["province"];
$cardname = $_POST["cardname"];
$cardnumber = cc_masking($_POST["cardnumber"]);
$expiry = $_POST["expiry"];

  $shoeNames = $_POST['shoe_name'];
  $sizes = $_POST['size'];
  $quantities = $_POST['quantity'];
  $totals = $_POST['total'];

  // Loop through the arrays and process the details for each shoe item
  for ($i = 0; $i < count($shoeNames); $i++) {
    $s_id = $s_ids[$i];
      $shoeName = $shoeNames[$i];
      $size = $sizes[$i];
      $quantity = $quantities[$i];
      $total = $totals[$i];
      
      
      $sql = "INSERT INTO orders (account_id, s_id, full_name, address, zip_code, province, cardname, card_number, expiry, shoe_name, size, quantity, total, order_date) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())";

      // Prepare the statement
      $stmt = $conn->prepare($sql);
      
      // Bind the parameters
      $stmt->bind_param(
          "iissssssssids",
          $account_id,
          $s_id,
          $full_name,
          $address,
          $zipcode,
          $province,
          $cardname,
          $cardnumber,
          $expiry,
          $shoeName,
          $size,
          $quantity,
          $total
      );
      

    // Execute the query
    $stmt->execute();
    

    $updateSql = "UPDATE shoe SET quantity = quantity - ? WHERE s_id = ?";
    $updateStmt = $conn->prepare($updateSql);
    $updateStmt->bind_param("ii", $quantity, $s_id);
    $updateStmt->execute();


    
    $processCompleted = 1;
  }
  

  if($processCompleted == 1){
    $deleteSql = "DELETE FROM cart WHERE account_id = ?";
    $deleteStmt = $conn->prepare($deleteSql);
    $deleteStmt->bind_param("i", $_SESSION['user_id']); 
    $deleteStmt->execute();
    $deleteStmt->close();
    $deleteCompelted = 1;
  }
 
  if($processCompleted == 1 && $deleteCompelted == 1){
    // require_once("invoicePDF.php");
    // $orderID = 1;
    // generateInvoice($orderID);
    header("location: product.php");
  }
  echo "<pre>";
  print_r($_POST);
  echo "</pre>";

}

function cc_masking($number, $maskingCharacter = 'X') {
  // Check if the number is empty or too short to mask
  if (empty($number) || strlen($number) <= 8) {
      return $number;
  }

  return substr($number, 0, 4) . str_repeat($maskingCharacter, strlen($number) - 8) . substr($number, -4);
}
if (isset($_SESSION['user_id'])) {
  $userId = $_SESSION['user_id'];

  // Fetch cart details with shoe information using JOIN
  $sql = "SELECT c.*, s.b_id, s.shoe_name, s.product_image, s.price, s.s_id
          FROM cart c
          INNER JOIN shoe s ON c.s_id = s.s_id
          WHERE c.account_id = ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param('i', $userId);
  $stmt->execute();
  $result = $stmt->get_result();

  $cartItems = array();
  while ($row = $result->fetch_assoc()) {
    $cartItems[] = $row;
  }

  $totalCartValue = 0;
  if (isset($cartItems) && !empty($cartItems)) {
      foreach ($cartItems as $item) {
          $totalCartValue += $item['quantity'] * $item['price'];
      }
  }
  $numRows = mysqli_num_rows($result);
}
?>


<?php require_once('header.php'); ?>

<?php require_once('navbar.php'); ?>


<header>
    <h1 class="text-center">Cart</h1>
  </header>

  <body>

  <section class="h-100 h-custom" style="background-color: #eee;">
  <form class="mb-4" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col">
                    <div class="card">
                        <div class="card-body p-4">

                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <h5 class="mb-0"><a href="product.php" class="text-body"><i
                                            class="fas fa-long-arrow-alt-left me-2"></i>Continue shopping</a></h5>
                                            <p class="mb-1">Shopping cart</p>
                                <div>
                                    <p class="mb-0">You have <?php echo $numRows; ?> items in your cart</p>
                                </div>
                            </div>
<!-- Display the cart items in cards -->
<?php if (isset($cartItems) && !empty($cartItems)) : ?>
    <?php foreach ($cartItems as $item) : ?>
        <div class="card mb-5">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div class="d-flex flex-row align-items-center">
                        <div>
                            <img src="<?php echo $item['product_image']; ?>" class="img-fluid rounded-3" alt="Shopping item" style="width: 65px;">
                        </div>
                        <div class="ms-3">
                            <h5><?php echo $item['shoe_name']; ?></h5>
                            <p class="small mb-0">Size:<?php echo $item['size']; ?></p>
                            <p class="small mb-0">Quantity:<?php echo $item['quantity']; ?></p>
                        </div>
                    </div>
                       <!-- Add hidden input fields to store shoe details -->
                <input type="hidden" name="s_id[]" value="<?php echo $item['s_id']; ?>" />
                <input type="hidden" name="shoe_name[]" value="<?php echo $item['shoe_name']; ?>" />
                <input type="hidden" name="size[]" value="<?php echo $item['size']; ?>" />
                <input type="hidden" name="quantity[]" value="<?php echo $item['quantity']; ?>" />
                <input type="hidden" name="total[]" value="<?php echo $item['price'] * $item['quantity']; ?>" />

                    <div class="d-flex flex-row align-items-center">
                        <div style="width: 50px;">
                            <h5 class="fw-normal mb-0"><?php echo $item['quantity']; ?></h5>
                        </div>
                        <div style="width: 80px;">
                            <h5 class="mb-0">$<?php echo $total = $item['price']*$item['quantity']; ?></h5>
                        </div>
                        <a href="removefromcart.php?c_id=<?php echo $item['c_id']; ?>" style="color: #cecece;" class="btn btn-danger"><i class="fas fa-trash-alt"></i></a>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
    <div class="text-center" >
        <h4  class="float-right" >Your Total: $<?php echo number_format($totalCartValue, 2); ?></h4>
    </div>
<?php else : ?>
    <!-- Display a message if the cart is empty -->
    <div class="card mb-5">
        <div class="card-body">
            <p class="text-center mb-0">Your cart is empty.</p>
        </div>
    </div>
<?php endif; ?>

<!-- shipping detail form -->
                                
          <h5 class="mb-3">Shipping Details</h5>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <div class="form-outline">
                                            <input type="text" id="fullName" class="form-control" name="full_name" placeholder="Full Name" />
                                            <label class="form-label" for="fullName">Full Name</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-outline">
                                            <input type="text" id="address" class="form-control" name="address"  placeholder="Address" />
                                            <label class="form-label" for="address">Address</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <div class="form-outline">
                                            <input type="text" id="zipCode" class="form-control" name="zipcode"  placeholder="ZIP Code" maxlength="6" />
                                            <label class="form-label" for="zipCode">ZIP Code</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-outline">
                                            <input type="text" id="province" class="form-control" name="province"  placeholder="Province" />
                                            <label class="form-label" for="province">Province</label>
                                        </div>
                                    </div>
                                </div>

                            <div class="card bg-primary text-white rounded-3">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center mb-4 ">
                                        <h5 class="mb-1 text-center">Card details</h5>
                                    </div>

                                    <p class="small mb-2">We Accept All Cards</p>
                                    <i class="fab fa-cc-mastercard fa-2x me-2"></i>
                                    <i class="fab fa-cc-visa fa-2x me-2"></i>
                                    <i class="fab fa-cc-amex fa-2x me-2"></i>
                                    <i class="fab fa-cc-paypal fa-2x"></i>

                                        <div class="form-outline form-white mb-4">
                                            <input type="text" id="typeName" name="cardname"  class="form-control form-control-lg"
                                                 placeholder="Cardholder's Name" />
                                            <label class="form-label" for="typeName">Cardholder's Name</label>
                                        </div>

                                        <div class="form-outline form-white mb-4">
                                            <input type="text" id="typeText" class="form-control form-control-lg"
                                                size="16" placeholder="1234 5678 9012 3457" name="cardnumber"  minlength="1"
                                                maxlength="19" />
                                            <label class="form-label" for="typeText">Card Number</label>
                                        </div>

                                        <div class="row mb-4">
                                            <div class="col-md-6">
                                                <div class="form-outline form-white">
                                                    <input type="text" id="typeExp" class="form-control form-control-lg"
                                                        placeholder="MMYY"  id="exp" name="expiry"  minlength="1"
                                                        maxlength="4" />
                                                    <label class="form-label" for="typeExp">Expiration</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-outline form-white">
                                                    <input type="password" id="typeText"
                                                        class="form-control form-control-lg" 
                                                        placeholder="&#9679;&#9679;&#9679;" size="1" minlength="1"
                                                        maxlength="3" />
                                                    <label class="form-label" for="typeText">Cvv</label>
                                                </div>
                                            </div>
                                        </div>
                                    </form>

                                    <hr class="my-4">

                                    <div class="d-flex justify-content-between">
                                        <p class="mb-2">Subtotal</p>
                                        <p class="mb-2">$<?php echo number_format($totalCartValue, 2); ?></p>
                                    </div>

                                    <div class="d-flex justify-content-between mb-4">
                                        <p class="mb-2">Total</p>
                                        <p class="mb-2">$<?php echo number_format($totalCartValue, 2); ?></p>
                                    </div>
                                    
                                      <input type="hidden" name="total1" value="<?php echo number_format($totalCartValue, 2); ?>" />
                                      <input type="hidden" name="account_id" value="<?php echo $_SESSION['user_id']; ?>" />
                                        <div class=" text-center" >
                                            <input type="submit" class="btn btn-success" value="Order Now" style="width: 20%;"/>
                                        </div>

                                </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </form>
    </section>


</body>

<?php require_once('footer.php'); ?> 

<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
