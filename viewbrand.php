<?php
session_start();
class BrandCRUD {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function getAllBrands() {
        $stmt = "SELECT * FROM brands";
        $stmt = mysqli_prepare($this->conn, $stmt);
        mysqli_stmt_execute($stmt);
        return mysqli_stmt_get_result($stmt);
    }
}

if (isset($_SESSION['username'])) {
    require_once("db_conn.php");

    $brandCRUD = new BrandCRUD($conn);
    $brandsResult = $brandCRUD->getAllBrands();
    $numRows = mysqli_num_rows($brandsResult);
} else {
    header("location: login.php");
    exit;
}
?>

<?php require_once('header.php'); ?>
<?php require_once('navbar.php'); ?>
<?php if (isset($_SESSION['message'])) : ?>
    <div class='alert alert-success alert-dismissible fade show' role='alert' style='margin-bottom: 0px;'>
<b><?php echo $_SESSION['message']; ?></b>
        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close' onclick="clearMessage()"></button>
    </div>
    <?php
    unset($_SESSION['message']);
    ?>
<?php endif; ?>

<section class="order-page py-5">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <h2 class="text-center mb-4">Brand Details</h2>
      </div>
    </div>
    <div class="row">
      <div class="col-md-12">
        <table class="table table-striped">
          <thead>
            <tr>
              <th>Brand Name</th>
              <th>Edit</th>
              <th>Delete</th>
            </tr>
          </thead>
          <tbody>
        <?php
        if ($numRows == 0) {
            echo "<tr><td colspan='3' class='text-center'><h4><b>No Brand Available</b></h4></td></tr>";
        } else {
            while ($row = mysqli_fetch_assoc($brandsResult)) {
        ?>
           <tr>
                <td>
                    <?php echo $row['b_name']; ?>
                </td>
                <td>
                    <a href="updatebrand.php?b_id=<?php echo $row['b_id']; ?>" class="btn btn-primary">Edit</a>
                </td>
                <td>
                    <a href="deletebrand.php?b_id=<?php echo $row['b_id']; ?>" class="btn btn-danger">Delete</a>
                </td>
            </tr>
            <?php
                }
            }
            ?>
          </tbody>
         
        </table>
      </div>
    </div>
  </div>
</section>

<?php require_once('footer.php'); ?>
<script>
    function clearMessage() {
        window.location.href = window.location.href;
    }
</script>