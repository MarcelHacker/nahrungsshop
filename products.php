<?php

/**
 * Php file for the products and details
 * 
 * Used for the product website
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
        <a class="nav-link active" href="products.php">Products</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="about.php">About</a>
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
  $userId = (int) $_SESSION['userId'];  // Gets user id from session variable
  $user = getCurrentUser($userId);      // int because function expects
  if (!$user) {
    echo "Error user Id <br>";
    die();
  } else {
    $countCartItems = countProductsInCart($userId);
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
$showProducts = true;

if (isset($_GET["add"])) {    // Add product to cart
  if (!isLoggedIn()) {
    echo "<label>Please login</label><br>";
  } else {
    if (!empty($_GET["add"])) {
      $productId = $_GET["add"];
      $result = addProductToCart($userId, $productId);
      if (!$result) {
        echo "Error product adding<br>";
      } else {
        header("Location: products.php"); // Reload the product page
      }
    } else {
      echo "<p>No product asked</p>";
    }
  }
}

if (isset($_GET["details"])) {  // See product details
  if (!empty($_GET["details"])) {
    $productId = $_GET["details"];

    $db = getDB();
    if (!$db) {
      echo "Error database connection <br>";
      die();
    } else {
      $statement = $db->prepare("SELECT * FROM products WHERE id = :productId");
      $result = $statement->execute(array('productId' => $productId));
      $product = $statement->fetch();    // User schon vorhanden?

      if (!$product) {
        echo "Error product Id <br>";
      } else {
        $productCategorie = getProductCategorie($product['id']);
        foreach ($productCategorie as $categorie) {       // Expects an array
          include_once("./template/productDetails.php");    // once because, only details on one product
        }
      }
      $showProducts = false;
    }
  }
}
if ($showProducts == true) {
  $products = getAllProducts();
  ?>
  <header>
    <section class="container" id="products">
      <div class="row" style="width: 55rem;">
        <?php foreach ($products as $product) :
          $productCategorie = getProductCategorie($product['id']);
          foreach ($productCategorie as $categorie) :
        ?>
            <div class="col">
              <?php
              include("./template/card.php") ?>
            </div>
        <?php endforeach;
        endforeach; ?>
      </div>
  </header>
<?php
}
?>
<div class="">
  <?= include_once("template/footer.php"); ?>
</div>
<script src="assets/js/bootstrap.min.js"></script>
</body>

</html>