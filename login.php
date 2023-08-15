<?php
session_start();
require_once("db_conn.php");

class Authentication {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function sanitizeInput($input){
        $input = str_replace(['(',')','"', ';'], '', $input);
        $input = strip_tags($input);
        $input = trim($input);
        $input = htmlentities($input, ENT_QUOTES, 'UTF-8');
        $input = htmlspecialchars($input);
        return $input;
    }

    public function login($username, $password) {
        $username = $this->sanitizeInput($username);
        $password = $this->sanitizeInput($password);

        $stmt = "SELECT password, user_type, account_id FROM account WHERE username = ?";
        $stmt = mysqli_prepare($this->conn, $stmt);
        mysqli_stmt_bind_param($stmt, "s", $username);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $row = mysqli_fetch_assoc($result);
        mysqli_stmt_close($stmt);

        if ($row && password_verify($password, $row['password'])) {
            $_SESSION['username'] = $username;
            $_SESSION['usertype'] = $row['user_type'];
            $_SESSION['user_id'] = $row['account_id'];
            setcookie('username', $username, time() + (86400), '/');
            
            if ($_SESSION['usertype'] === "Admin") {
                header("location: home.php"); 
            } elseif ($_SESSION['usertype'] === "User") {
                setcookie('brand', 'Nike', time() + (86400), '/');
                header("location: home.php"); 
            } else {
                header("location: login.php"); 
            }
            exit;
        } else {
            echo "<div class='alert alert-danger alert-dismissible fade show' role='alert' style='margin-bottom: 0px;'>Invalid username or password.<button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button></div>";
        }
    }
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $authenticator = new Authentication($conn);
    $authenticator->login($_POST["username"], $_POST["password"]);
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
        <h2 class="mb-4 text-center">Login</h2>
        <form method="POST" action="<?php echo $_SERVER['PHP_SELF'];?>" id="login-form">
          <div class="mb-3">
            <label for="username" class="form-label">Username</label>
            <input type="text" class="form-control" id="username" name="username" placeholder="User Name">
            <span class="text-danger" id="username-error"><?php echo isset($errors['username']) ? $errors['username'] : ''; ?></span>

          </div>
          <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" id="password" name="password" placeholder="Password">
            <span class="text-danger" id="password-error"><?php echo isset($errors['password']) ? $errors['password'] : ''; ?></span>

          </div>
          <div class="text-center">
            <button type="submit" class="btn btn-primary">Login</button>
          </div>
          <div class="text-center mt-3">
            <a href="registration.php">Create Account</a>
          </div>
        </form>
      </div>
    </div>
  </div>
</section>

<?php require_once('footer.php'); ?>

<script>
  const form = document.getElementById("login-form");

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
    const password = document.getElementById("password").value.trim();

    document.getElementById("username-error").textContent = "";
    document.getElementById("password-error").textContent = "";

    if (username === "") {
      document.getElementById("username-error").textContent = "Username is required.";
      isValid = false;
    }
    if (password === "") {
      document.getElementById("password-error").textContent = "Password is required.";
      isValid = false;
    }

    return isValid;
  }
</script>