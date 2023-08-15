<?php
require_once("db_conn.php");

class Database {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function insertAdmin($username, $email, $password, $user_type) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $query = "INSERT INTO account (username, email, password, user_type) VALUES (?, ?, ?, ?)";
        $stmt = mysqli_prepare($this->conn, $query);
        mysqli_stmt_bind_param($stmt, "ssss", $username, $email, $hashedPassword, $user_type);

        $result = mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        return $result;
    }

    public function checkExistingUsername($username) {
        $query = "SELECT * FROM account WHERE username = ?";
        $stmt = mysqli_prepare($this->conn, $query);
        mysqli_stmt_bind_param($stmt, "s", $username);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $existingUser = mysqli_num_rows($result) > 0;
        mysqli_stmt_close($stmt);
        return $existingUser;
    }

    public function checkExistingEmail($email) {
        $query = "SELECT * FROM account WHERE email = ?";
        $stmt = mysqli_prepare($this->conn, $query);
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $existingEmail = mysqli_num_rows($result) > 0;
        mysqli_stmt_close($stmt);
        return $existingEmail;
    }
}
function sanitizeInput($input) {
  $input = str_replace(['(', ')', '"', ';'], '', $input);
  $input = strip_tags($input);
  $input = trim($input);
  $input = htmlentities($input, ENT_QUOTES, 'UTF-8');
  $input = htmlspecialchars($input);
  return $input;
}

$errors = array();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $db = new Database($conn);

  $username = sanitizeInput($_POST["adminname"]);
  $email = sanitizeInput($_POST["adminemail"]);
  $password = sanitizeInput($_POST["adminPassword"]);
  $cpassword = sanitizeInput($_POST["cpassword"]);
  $user_type = "Admin";

  if ($db->checkExistingUsername($username)) {
      $errors["adminname"] = "Admin Name is already taken. Please choose a different Admin Name.";
  }

  if ($db->checkExistingEmail($email)) {
      $errors["adminemail"] = "Admin Email is already registered. Please use a different Admin Email.";
  }

  if (empty($errors)) {
      $result = $db->insertAdmin($username, $email, $password, $user_type);
      if ($result) {
          echo "Data inserted successfully!";
          header("location: admin_login.php");
          exit;
      } else {
          echo "Error inserting data.";
          header("location: admin_registration.php");
      }
  }
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

<section class="registration-section py-5">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-md-6">
          <h2 class="mb-4 text-center">Admin Sign up</h2>
          <form method="POST" action="<?php echo $_SERVER['PHP_SELF'];?>" id="admin-registration-form">
            <div class="mb-3">
              <label for="adminname" class="form-label">Admin Name</label>
              <input type="text" class="form-control" id="adminname" name="adminname" placeholder="Admin Name"
                value="<?php echo isset($adminname) ? $adminname : ''; ?>">
              <span class="text-danger" id="adminname-error"><?php echo isset($errors['adminname']) ? $errors['adminname'] : ''; ?></span>
            </div>
            <div class="mb-3">
              <label for="adminemail" class="form-label">Admin Email</label>
              <input type="text" class="form-control" id="adminemail" name="adminemail" placeholder="Admin Email"
                value="<?php echo isset($adminemail) ? $adminemail : ''; ?>">
              <span class="text-danger" id="adminemail-error"><?php echo isset($errors['adminemail']) ? $errors['adminemail'] : ''; ?></span>
            </div>
            <div class="mb-3">
              <label for="adminPassword" class="form-label">Password</label>
              <input type="password" class="form-control" id="adminPassword" name="adminPassword" placeholder="Admin Password">
              <span class="text-danger" id="adminPassword-error"><?php echo isset($errors['adminPassword']) ? $errors['adminPassword'] : ''; ?></span>
            </div>
            <div class="mb-3">
              <label for="cpassword" class="form-label">Confirm Password</label>
              <input type="password" class="form-control" id="cpassword" name="cpassword" placeholder="Confirm Password">
              <span class="text-danger" id="cpassword-error"><?php echo isset($errors['cpassword']) ? $errors['cpassword'] : ''; ?></span>
            </div>
            <div class="text-center">
              <button type="submit" class="btn btn-primary">Sign up</button>
            </div>
            <div class="text-center mt-3">
              <a href="admin_login.php">Already a user</a>
            </div>
          </form>
        </div>
      </div>
    </div>
  </section>

  <?php require_once('footer.php'); ?>
<script>

  const form = document.getElementById("admin-registration-form");

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
    const adminemail = document.getElementById("adminemail").value.trim();
    const adminPassword = document.getElementById("adminPassword").value.trim();
    const cpassword = document.getElementById("cpassword").value.trim();

    document.getElementById("adminname-error").textContent = "";
    document.getElementById("adminemail-error").textContent = "";
    document.getElementById("adminPassword-error").textContent = "";
    document.getElementById("cpassword-error").textContent = "";

    if (adminname === "") {
      document.getElementById("adminname-error").textContent = "Admin Name is required.";
      isValid = false;
    }

    if (adminemail === "") {
      document.getElementById("adminemail-error").textContent = "Admin Email is required.";
      isValid = false;
    } else if (!emailIsValid(adminemail)) {
      document.getElementById("adminemail-error").textContent = "Invalid email format.";
      isValid = false;
    }

    if (adminPassword === "") {
      document.getElementById("adminPassword-error").textContent = "Password is required.";
      isValid = false;
    }

    if (cpassword === "") {
      document.getElementById("cpassword-error").textContent = "Confirm Password is required.";
      isValid = false;
    } else if (adminPassword !== cpassword) {
      document.getElementById("cpassword-error").textContent = "Passwords do not match.";
      isValid = false;
    }

    return isValid;
  }

  function emailIsValid(adminemail) {
    return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(adminemail);
  }
  
</script>