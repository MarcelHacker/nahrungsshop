<?php

/**
 * Php file for the information and contact
 * 
 * Used for the about website
 * 
 */
session_start();        // For session variable  
include_once("./template/header.php");      // For functions

if (!isLoggedIn()) //wenn nicht eingeloggt User.php nicht anzeigen
{
?>
  <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <ul class="nav nav-tabs">
      <li class="nav-item">
        <a class="nav-link" href="index.php">Home</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="products.php">Products</a>
      </li>
      <li class="nav-item">
        <a class="nav-link active" href="about.php">About</a>
      </li>
      <li class="nav-item">
        <a class="btn mr-sm-4 btn-outline-dark" href="login.php">Sign In</a>
      </li>
    </ul>
    <form class="form-inline my-2 my-lg-0" action="search.php" method="POST">
      <input class="form-control mr-sm-1" type="search" placeholder="Search" id="search_term" name="search_term" aria-label="Search">
      <button class="btn btn-outline-success my-2 my-sm-0" type="submit" name="search" id="search">Search</button>
    </form>
    </div>
  </nav>
  <?php
} else {
  $userId = $_SESSION['userId'];
  $user = getCurrentUser($userId);
  if (!$user) {
    echo "Error User<br>";
  } else {
    $countCartItems = countProductsInCart($userId);
  ?>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
      <ul class="nav nav-tabs">
        <li class="nav-item">
          <a class="nav-link" href="index.php">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="products.php">Products</a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" href="about.php">About</a>
        </li>
        <li class="nav-item">
          <a class="btn mr-sm-4 btn-outline-dark" href="logout.php">Logout</a>
        </li>
      </ul>
      <form class="form-inline my-2 my-lg-0" action="search.php" method="POST">
        <input class="form-control mr-sm-1" type="search" placeholder="Search" id="search_term" name="search_term" aria-label="Search">
        <button class="btn btn-outline-success my-2 my-sm-0" type="submit" name="search" id="search">Search</button>
      </form>
      </div>
      <ul class="navbar-nav ml-auto">
        <li class="nav-item">
          <i class="fas fa-shopping-cart">
            <a href="cart.php">Cart (<?= $countCartItems ?>)</a>
          </i>
        </li>
      </ul>
    </nav>
<?php
  }
}
include_once("./template/aboutCard.php"); // About picture
$showContactFormular = true;

if (isset($_POST['contact'])) { // For contact formular
  $email = $_POST['email'];
  $name = $_POST['name'];
  $subj = $_POST['subject'];
  $mesg = $_POST['message'];

  $db = getDB();  // database connection
  if (!$db) {
    echo "Error database connection <br>";
    die();
  } else {  // generate database entry
    $sql = "insert into contact (email,name,subject,message) values('$email','$name','$subj','$mesg')";
    $statement = $db->prepare($sql);
    $result = $statement->execute(array('email' => $email, 'name' => $name, 'subject' => $subj, 'message' => $mesg));

    if ($result) {   // Message sent
      echo "<font> Message sent successfully </font><br>";
      $showContactFormular = false;
    } else {        // Error
      echo "<font> Error contact message </font><br>";
    }
  }
}
if ($showContactFormular == true) {  // Hides contact if sent
  include_once("./template/contactForm.php");
}
?>
<div class="sm">
  <?= include_once("./template/footer.php"); ?>
</div>
<script src="assets/js/bootstrap.min.js"></script>
</body>

</html>