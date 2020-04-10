<?php
session_start();
include_once("template/header.php");

if (!isset($_SESSION['userId'])) //wenn nicht eingeloggt User.php nicht anzeigen
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
    <form class="form-inline my-2 my-lg-0" action="search.php" method="GET">
      <input class="form-control mr-sm-1" type="search" placeholder="Search" aria-label="Search">
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
    // cart Item
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
      <form class="form-inline my-2 my-lg-0" action="search.php" method="GET">
        <input class="form-control mr-sm-1" type="search" placeholder="Search" aria-label="Search">
        <button class="btn btn-outline-success my-2 my-sm-0" type="submit" name="search" id="search">Search</button>
      </form>
      </div>
      <ul class="navbar-nav ml-auto">
        <li class="nav-item">
          Cart ()
        </li>
      </ul>
    </nav>
<?php
    //<?= $cartItems 
  }
}
include_once("template/aboutCard.php");
?>
<form action="contact.php" method="POST">
  <div class="container">
    <h2><span class="badge badge-secondary-">Contact Us</span></h2>
    <div class="form-group">
      <label for="exampleFormControlInput1">Email address</label>
      <input type="email" name="email" class="form-control" id="exampleFormControlInput1" placeholder="name@example.com">
    </div>
    <div class="form-group">
      <label for="exampleFormControlInput1">Name</label>
      <input type="text" name="name" class="form-control" id="exampleFormControlInput1" placeholder="Max Mustermann">
    </div>
    <div class="form-group">
      <label for="exampleFormControlInput1">Subject</label>
      <input type="text" name="subject" class="form-control" id="exampleFormControlInput1" placeholder="product request">
    </div>
    <div class="form-group">
      <label for="exampleFormControlTextarea1">Message</label>
      <textarea class="form-control" name="message" id="exampleFormControlTextarea1" rows="3"></textarea>
    </div>
    <div>
      <button type="submit" name="contact" class="btn btn-info"> Send </button>
    </div>
  </div>
</form>
<div class="">
  <?= include_once("template/footer.php"); ?>
</div>
<script src="assets/js/bootstrap.min.js"></script>
</body>

</html>