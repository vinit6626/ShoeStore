<?php
session_start();
class ContactUsCRUD {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function getAllMessages() {
        $stmt = "SELECT * FROM contact_us";
        $stmt = mysqli_prepare($this->conn, $stmt);
        mysqli_stmt_execute($stmt);
        return mysqli_stmt_get_result($stmt);
    }
}


if (isset($_SESSION['username'])) {
  require_once("db_conn.php");

  $contactUsCRUD = new ContactUsCRUD($conn);
  $result = $contactUsCRUD->getAllMessages();
  $numRows = mysqli_num_rows($result);
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
        <h2 class="text-center mb-4">User Messsages Details</h2>
      </div>
    </div>
    <div class="row">
      <div class="col-md-12">
        <table class="table table-striped">
          <thead>
            <tr>
              <th>Name</th>
              <th>Email</th>
              <th>Phone</th>
              <th>Message</th>
              <th>Delete</th>
            </tr>
          </thead>
          <tbody>
          <?php if ($numRows == 0) {
            // If there are no categories, display the message here
            echo "<tr><td colspan='9' class='text-center'><h4><b>No Message Available</b></h4></td></tr>";
        } else {
          while ($row = mysqli_fetch_assoc($result)) : ?>
              <tr>
                <td><?php echo $row['name']; ?></td>
                <td><?php echo $row['email']; ?></td>
                <td><?php echo $row['phone']; ?></td>
                <td><?php echo $row['message']; ?></td>
              </td>
                <td>
                <a href="deletemessage.php?cu_id=<?php echo $row['cu_id']; ?>" class="btn btn-danger">Contacted to User</a>
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
