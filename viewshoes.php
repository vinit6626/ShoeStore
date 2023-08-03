<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once("db_conn.php");

$stmt = "SELECT s_id,b.b_name AS brand_name, c.c_name AS category_name, s.shoe_name, s.gender, s.shoe_sizes, s.product_description, s.product_image, s.price, s.quantity
         FROM shoe s
         INNER JOIN brands b ON s.b_id = b.b_id
         INNER JOIN categories c ON s.c_id = c.c_id";
$result = mysqli_query($conn, $stmt);
$numRows = mysqli_num_rows($result);
?>
<?php require_once('header.php'); ?>
<?php require_once('navbar.php'); ?>


<?php if (isset($_SESSION['message'])) : ?>
    <div class='alert alert-success alert-dismissible fade show' role='alert' style='margin-bottom: 0px;'>
<b><?php echo $_SESSION['message']; ?></b>
        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close' onclick='clearMessage()'></button>
    </div>
    <?php
    unset($_SESSION['message']);
    ?>
<?php endif; ?>
  
<section class="order-page py-5">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <h2 class="text-center mb-4">Shoe Product Details</h2>
      </div>
    </div>
    <div class="row">
      <div class="col-md-12">
        <table class="table table-striped">
          <thead>
            <tr>
              <th>Brand Name</th>
              <th>Category Name</th>
              <th>Shoe Name</th>
              <th>Product Description</th>
              <th>Gender</th>
              <th>Available Sizes</th>
              <th>Price</th>
              <th>Quantity</th>
              <th>Product Image</th>
              <th>Edit</th>
              <th>Delete</th>
            </tr>
          </thead>
          <tbody>
          <?php if ($numRows == 0) {
            // If there are no categories, display the message here
            echo "<tr><td colspan='9' class='text-center'><h4><b>No Category Available</b></h4></td></tr>";
        } else {
          while ($row = mysqli_fetch_assoc($result)) : ?>
              <tr>
                <td><?php echo $row['brand_name']; ?></td>
                <td><?php echo $row['category_name']; ?></td>
                <td><?php echo $row['shoe_name']; ?></td>
                <td><?php echo $row['product_description']; ?></td>
                <td><?php echo $row['gender']; ?></td>
                <td><?php echo $row['shoe_sizes']; ?></td>
                <td><?php echo "$".$row['price']; ?></td>
                <td><?php echo $row['quantity']; ?></td>
                <td><img src="<?php echo $row['product_image']; ?>" alt="Product Image" width="100"></td>

                <td>
                  <a href="updateshoes.php?s_id=<?php echo $row['s_id']; ?>" class="btn btn-primary">Edit</a>
              </td>
                <td>
                <a href="deleteshoe.php?s_id=<?php echo $row['s_id']; ?>" class="btn btn-danger">Delete</a>
              </td>
              </tr>
            <?php endwhile; ?>
            <?php
                }
            ?>
          </tbody>
         
        </table>
      </div>
    </div>
  </div>
</section>

<!-- Footer Section -->
<?php require_once('footer.php'); ?>
