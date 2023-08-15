<?php
session_start();
class CategoryCRUD {
    private $conn;
    public function __construct($conn) {
        $this->conn = $conn;
    }
    public function getAllCategories() {
        $stmt = "SELECT * FROM categories";
        $stmt = mysqli_prepare($this->conn, $stmt);
        mysqli_stmt_execute($stmt);
        return mysqli_stmt_get_result($stmt);
    }
}
if (isset($_SESSION['username'])) {
  require_once("db_conn.php");
  $categoryCRUD = new CategoryCRUD($conn);
  $categoriesResult = $categoryCRUD->getAllCategories();
  $numRows = mysqli_num_rows($categoriesResult);
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
        <h2 class="text-center mb-4">Category Details</h2>
      </div>
    </div>
    <div class="row">
      <div class="col-md-12">
        <table class="table table-striped">
          <thead>
            <tr>
              <th>Category Name</th>
              <th>Edit</th>
              <th>Delete</th>
            </tr>
          </thead>
          <tbody>
            
        <?php
        if ($numRows == 0) {
            echo "<tr><td colspan='3' class='text-center'><h4><b>No Category Available</b></h4></td></tr>";
        } else {
            while ($row = mysqli_fetch_assoc($categoriesResult)) {
        ?>
           <tr>
                <td>
                    <?php echo $row['c_name']; ?>
                </td>
                <td>
                    <a href="updatecategory.php?c_id=<?php echo $row['c_id']; ?>" class="btn btn-primary">Edit</a>
                </td>
                <td>
                    <a href="deletecategory.php?c_id=<?php echo $row['c_id']; ?>" class="btn btn-danger">Delete</a>
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