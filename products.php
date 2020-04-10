<?php
session_start();
include_once("template/header.php");
//$userId = getCurrentUserId();
//$cartItems = countProductsInCart($userId); 

if (!isset($_SESSION['userId'])) //wenn nicht eingeloggt User.php nicht anzeigen
{
?>
  <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <ul class="nav nav-tabs">
      <li class="nav-item">
        <a class="nav-link" href="index.php">Home</a>
      </li>
      <li class="nav-item">
        <a class="nav-link active" href="products.php">Products</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="about.php">About</a>
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
    echo "Error user Id <br>";
  } else {
    $cartItems = countProductsInCart($userId);
  ?>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
      <ul class="nav nav-tabs">
        <li class="nav-item">
          <a class="nav-link" href="index.php">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" href="products.php">Products</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="about.php">About</a>
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
          Cart (<?= $cartItems ?>)
        </li>
      </ul>
    </nav>
    <?php
  }
}
if (isset($_GET["add"])) {
  if (!isset($_SESSION['userId'])) {
    echo "<label>Please login</label><br>";
  } else {
    if (!empty($_GET["add"])) {
      $productId = $_GET["add"];
      addProductToCart($userId, $productId);
    } else {
    ?>
      <p>No product asked</p>
    <?php
    }
    ?>
    <p>No product asked</p>
<?php
  }
}
if (isset($_GET["details"])) {
  if (!empty($_GET["details"])) {
    $productId = $_GET["details"];
    //TODO product details modal
    echo "hallo infos";
  }
}
$products = getAllProducts();
?>
<header>
  <section class="container" id="products">
    <div class="row" style="width: 45rem;">
      <?php foreach ($products as $product) : ?>
        <div class="col">
          <?php include("template/card.php") ?>
        </div>
      <?php endforeach; ?>
    </div>
</header>
<?php include_once("template/footer.php"); ?>
<script src="assets/js/bootstrap.min.js"></script>
</body>

</html>