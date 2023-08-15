<?php
class OrderManager {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function getOrdersByAccountId($account_id) {
        $query = "SELECT o.shoe_name, o.size, o.quantity, o.total, o.order_date, s.product_image
                  FROM orders o
                  JOIN shoe s ON o.s_id = s.s_id
                  WHERE account_id = ?
                  ORDER BY o.o_id DESC";

        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $account_id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }
}

session_start();
require_once("db_conn.php");

if (isset($_SESSION['username'])) {
    $account_id = $_SESSION['user_id'];

    $orderManager = new OrderManager($conn);
    $orders = $orderManager->getOrdersByAccountId($account_id);

    $row_count = count($orders);
} else {
    header("location: login.php");
    exit;
}
?>

<?php require_once('header.php'); ?>
<?php require_once('navbar.php'); ?>

<section class="hero-section custom-bg homepage-heading-section">
  <div class="container text-center homepage-heading-div">
    <h1 class="text-white">Welcome to Shoe Store</h1>
    <p class="text-white">Explore our latest collection of stylish shoes for every occasion.</p>
    
  </div>
</section>

<section class="order-page py-5">
<?php if($row_count > 0) { ?>
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <h2 class="text-center mb-4">Your Order Details</h2>
      </div>
    </div>

    <div class="text-center mb-5 mt-2">
    <a class="btn btn-success " target="_blank" href="pdfg.php">Download Your Latest Invoice</a>
    </div>

    <div class="row">
      <div class="col-md-12">
        <table class="table table-striped">
          <thead>
            <tr>
              <th>Shoe Image</th>
              <th>Shoe Name</th>
              <th>Size</th>
              <th>Quantity</th>
              <th>Subtotal</th>
              <th>Date of Order</th>
            </tr>
          </thead>
          <tbody>
            <?php 
            foreach ($orders as $order) {
              echo '<tr>';
              echo '<td><img src="' . $order['product_image'] . '" alt="Shoe Image" width="50"></td>';
              echo '<td>' . $order['shoe_name'] . '</td>';
              echo '<td>' . $order['size'] . '</td>';
              echo '<td>' . $order['quantity'] . '</td>';
              echo '<td>$' . $order['total'] . '</td>';
              echo '<td>' . $order['order_date'] . '</td>';
              echo '</tr>';
            }
            ?>
          </tbody>
        </table>
      </div>
    </div>
    <?php } else { ?>
      <h2 class="text-center" > You haven't ordered anything yet! </h2>
    </div>
    <?php } ?>
</section>

<?php require_once('footer.php'); ?>