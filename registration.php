<?php
require_once("db_conn.php");
$errors = array();

class UserRegistration {
  private $conn;

  public function __construct($conn) {
    $this->conn = $conn;
  }

  public function isUsernameTaken($username) {
    $query = "SELECT * FROM account WHERE username = ?";
    $stmt = mysqli_prepare($this->conn, $query);
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    return mysqli_num_rows($result) > 0;
  }

  public function isEmailRegistered($email) {
    $query = "SELECT * FROM account WHERE email = ?";
    $stmt = mysqli_prepare($this->conn, $query);
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    return mysqli_num_rows($result) > 0;
  }

  public function registerUser($username, $email, $hashedPassword, $user_type) {
    $query = "INSERT INTO account (username, email, password, user_type) VALUES (?, ?, ?, ?)";
    $stmt = mysqli_prepare($this->conn, $query);
    mysqli_stmt_bind_param($stmt, "ssss", $username, $email, $hashedPassword, $user_type);
    return mysqli_stmt_execute($stmt);
  }
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  function sanitizeInput($input){
    $input = str_replace(['(',')','"', ';'], '', $input);
    $input = strip_tags($input);
    $input = trim($input);
    $input = htmlentities($input, ENT_QUOTES, 'UTF-8');
    $input = htmlspecialchars($input);
    
    return $input;
  }
  $username = sanitizeInput($_POST["username"]);
  $email = sanitizeInput($_POST["email"]);
  $password = sanitizeInput($_POST["password"]);
  $cpassword = sanitizeInput($_POST["cpassword"]);
  $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
  $user_type = "User";

  $userRegistration = new UserRegistration($conn);

  if ($userRegistration->isUsernameTaken($username)) {
    $errors["username"] = "Username is already taken. Please choose a different username.";
  }

  if ($userRegistration->isEmailRegistered($email)) {
    $errors["email"] = "Email is already registered. Please use a different email.";
  }

  if (empty($errors)) {
    if ($userRegistration->registerUser($username, $email, $hashedPassword, $user_type)) {
      echo "Data inserted successfully!";
      header("location: login.php");
      exit;
    } else {
      echo "Error inserting data into the database.";
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
          <h2 class="mb-4 text-center">Registration</h2>
          <form method="POST" action="<?php echo $_SERVER['PHP_SELF'];?>" id="registration-form">
            <div class="mb-3">
              <label for="username" class="form-label">Username</label>
              <input type="text" class="form-control" id="username" name="username" placeholder="User Name"
                value="<?php echo isset($username) ? $username : ''; ?>">
              <span class="text-danger" id="username-error"><?php echo isset($errors['username']) ? $errors['username'] : ''; ?></span>
            </div>
            <div class="mb-3">
              <label for="email" class="form-label">Email</label>
              <input type="text" class="form-control" id="email" name="email" placeholder="Email"
                value="<?php echo isset($email) ? $email : ''; ?>">
              <span class="text-danger" id="email-error"><?php echo isset($errors['email']) ? $errors['email'] : ''; ?></span>
            </div>
            <div class="mb-3">
              <label for="password" class="form-label">Password</label>
              <input type="password" class="form-control" id="password" name="password" placeholder="Password">
              <span class="text-danger" id="password-error"><?php echo isset($errors['password']) ? $errors['password'] : ''; ?></span>
            </div>
            <div class="mb-3">
              <label for="cpassword" class="form-label">Confirm Password</label>
              <input type="password" class="form-control" id="cpassword" name="cpassword" placeholder="Confirm Password">
              <span class="text-danger" id="cpassword-error"><?php echo isset($errors['cpassword']) ? $errors['cpassword'] : ''; ?></span>
            </div>
            <div class="text-center">
              <button type="submit" class="btn btn-primary">Register</button>
            </div>
            <div class="text-center mt-3">
              <a href="login.php">Already a user</a>
            </div>
          </form>
        </div>
      </div>
    </div>
  </section>

  <?php require_once('footer.php'); ?>
<script>

  const form = document.getElementById("registration-form");

  form.addEventListener("submit", function(event) {
    event.preventDefault(); 
    const isValid = validateForm();

    if (isValid) {
      form.submit();
    }
  });

  function validateForm() {
    let isValid = true;
    const username = document.getElementById("username").value.trim();
    const email = document.getElementById("email").value.trim();
    const password = document.getElementById("password").value.trim();
    const cpassword = document.getElementById("cpassword").value.trim();

    document.getElementById("username-error").textContent = "";
    document.getElementById("email-error").textContent = "";
    document.getElementById("password-error").textContent = "";
    document.getElementById("cpassword-error").textContent = "";

    if (username === "") {
      document.getElementById("username-error").textContent = "Username is required.";
      isValid = false;
    }

    if (email === "") {
      document.getElementById("email-error").textContent = "Email is required.";
      isValid = false;
    } else if (!emailIsValid(email)) {
      document.getElementById("email-error").textContent = "Invalid email format.";
      isValid = false;
    }

    if (password === "") {
      document.getElementById("password-error").textContent = "Password is required.";
      isValid = false;
    }

    if (cpassword === "") {
      document.getElementById("cpassword-error").textContent = "Confirm Password is required.";
      isValid = false;
    } else if (password !== cpassword) {
      document.getElementById("cpassword-error").textContent = "Passwords do not match.";
      isValid = false;
    }

    return isValid;
  }
  function emailIsValid(email) {
    return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
  }
  
</script>