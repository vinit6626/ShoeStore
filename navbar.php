
<!-- Navigation Bar -->
<nav class="navbar navbar-expand-lg bg-dark navbar-dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="index.php">Shoe Store</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarText">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link" href="index.php">Home</a>
        </li>
        
        <?php 
        session_start();
        if(isset($_SESSION['username'])){
          if(($_SESSION['usertype'] == "Admin")){
        ?>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Insert Section
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="insertcategory.php">Insert Shoe Category</a></li>
            <li><a class="dropdown-item" href="viewcategory.php">View Shoe Category</a></li>
            <div class="dropdown-divider"></div>
            <li><a class="dropdown-item" href="insertbrand.php">Insert Shoe Brand</a></li>
            <a class="dropdown-item" href="viewbrand.php">View Show Brand</a>
            <div class="dropdown-divider"></div>
            <li><a class="dropdown-item" href="insertshoes.php">Insert Shoe Product</a></li>
            <a class="dropdown-item" href="viewshoes.php">View Show Product</a>
            <div class="dropdown-divider"></div>
            <li><a class="dropdown-item" href="product.php">View Product</a></li>
          </ul>
        </li>
        <?php
          }
          if(($_SESSION['usertype'] == "User")){
        ?>
        <li class="nav-item">
          <a class="nav-link" href="product.php">Products</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="cart.php">Cart</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="myorder.php">My Order</a>
        </li>
        <?php } }?>

        <li class="nav-item">
          <a class="nav-link" href="about.php">About</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="contact.php">Contact</a>
        </li>
      </ul>
      <ul class="navbar-nav">
       
      <?php
        // Check if the user is logged in
        session_start();
        if (isset($_SESSION['username']) ) {
          // User is logged in, show logout button
          ?>
          <li class="nav-item">
            <a class="nav-link" href="logout.php">Logout</a>
          </li>
          <?php
        } else {
          // User is not logged in, show login button
          ?>
          <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
          Login
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="login.php">User Login</a></li>
            <li><a class="dropdown-item" href="admin_login.php">Admin Login</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="#">Something else here</a></li>
          </ul>
        </li>


          <li class="nav-item">
          <a class="nav-link" href="registration.php">Register</a>
        </li>
          <?php
        }
        ?>
        
      </ul>
    </div>
  </div>
</nav>
