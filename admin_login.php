<?php
session_start();

require_once("db_conn.php");

class AuthManager {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function sanitizeInput($input) {
        $input = str_replace(['(',')','"', ';'], '', $input);
        $input = strip_tags($input);
        $input = trim($input);
        $input = htmlentities($input, ENT_QUOTES, 'UTF-8');
        $input = htmlspecialchars($input);
        return $input;
    }

    public function loginUser($adminname, $adminPassword) {
        $adminname = $this->sanitizeInput($adminname);

        $stmt = "SELECT password FROM account WHERE username = ?";
        $stmt = mysqli_prepare($this->conn, $stmt);
        mysqli_stmt_bind_param($stmt, "s", $adminname);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $row = mysqli_fetch_assoc($result);
        $hashedPassword = $row['password'];
        mysqli_stmt_close($stmt);

        if (password_verify($adminPassword, $hashedPassword)) {
            $_SESSION['username'] = $adminname;
            $_SESSION['usertype'] = "Admin";
            return true;
        } else {
            return false;
        }
    }
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $authManager = new AuthManager($conn);

    $adminname = $_POST["adminname"];
    $adminPassword = $_POST["adminPassword"];

    if (empty($adminname) || empty($adminPassword)) {
        echo "Please enter both username and password.";
        exit;
    }

    if ($authManager->loginUser($adminname, $adminPassword)) {
        header("location: home.php"); 
        exit;
    } else {
        echo "<div class='alert alert-danger alert-dismissible fade show' role='alert' style='margin-bottom: 0px;'>Invalid user name or password.<button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button></div>";
    }
}
?>

<?php require_once('header.php'); ?>
<?php require_once('navbar.php'); ?>
<section class="hero-section custom-bg homepage-heading-section">
  <div class="container text-center homepage-heading-div">
    <h1 class="text-white">Welcome to Shoe Store</h1>
    <p class="text-white">Login now and access our service.</p>
    
  </div>
</section>


<section class="login-section py-5">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-6">
        <h2 class="mb-4 text-center">Admin Login</h2>
        <form method="POST" action="<?php echo $_SERVER['PHP_SELF'];?>" id="admin-login-form">
          <div class="mb-3">
            <label for="adminname" class="form-label">Admin Name</label>
            <input type="text" class="form-control" id="adminname" name="adminname" placeholder="Admin User Name">
            <span class="text-danger" id="adminname-error"><?php echo isset($errors['adminname']) ? $errors['adminname'] : ''; ?></span>

          </div>
          <div class="mb-3">
            <label for="adminPassword" class="form-label">Password</label>
            <input type="password" class="form-control" id="adminPassword" name="adminPassword" placeholder="Admin Password">
            <span class="text-danger" id="adminPassword-error"><?php echo isset($errors['adminPassword']) ? $errors['adminPassword'] : ''; ?></span>

          </div>
          <div class="text-center">
            <button type="submit" class="btn btn-primary">Login</button>
          </div>
          <div class="text-center mt-3">
            <a href="admin_registration.php">Create Account</a>
          </div>
        </form>
      </div>
    </div>
  </div>
</section>

<?php require_once('footer.php'); ?>

<script>
  const form = document.getElementById("admin-login-form");

  form.addEventListener("submit", function(event) {
    event.preventDefault(); 
    const isValid = validateForm();

    if (isValid) {
      form.submit();
    }
  });

  function validateForm() {
    let isValid = true;
    const adminname = document.getElementById("adminname").value.trim();
    const adminPassword = document.getElementById("adminPassword").value.trim();

    document.getElementById("adminname-error").textContent = "";
    document.getElementById("adminPassword-error").textContent = "";

    if (adminname === "") {
      document.getElementById("adminname-error").textContent = "Admin Username is required.";
      isValid = false;
    }

    if (adminPassword === "") {
      document.getElementById("adminPassword-error").textContent = "Admin Password is required.";
      isValid = false;
    }

    return isValid;
  }

</script>