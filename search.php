<?php

/**
 * Php file for the product search query
 * 
 * Used for the website
 * 
 */
session_start();        // For session variable  
include_once("./template/header.php");    // For functions

if (!isLoggedIn()) // user logged in?
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
  if (!$user) { // No user with this id?
    echo "Error User Id <br>";
    die();
  } else {
    $countCartItems = countProductsInCart($userId); // Count cart items
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
          <a class="nav-link" href="about.php">About</a>
        </li>
        <li class="nav-item">
          <a class="btn mr-sm-4 btn-outline-dark" href="logout.php">Logout</a>
        </li>
      </ul>
      <form class="form-inline my-2 my-lg-0" action="search.php" method="POST">
        <input class="form-control mr-sm-1" type="search" name="search_term" id="search_term" placeholder="Search" aria-label="Search">
        <button class="btn btn-outline-success my-2 my-sm-0 active" type="submit" name="search" id="search">Search</button>
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

if (isset($_POST["search"])) {  // For site search query
  $search = $_POST["search_term"];

  $sql = "SELECT * FROM products
          WHERE title like '$search'";
  $products = getProducts($sql);  // Get searched product with title

  if (!$products) { // No products found?
    echo "No products found<br>";
  } else {          // Some products found?
    echo "Following products were found:<br>";
  ?>
    <header>
      <section class="container px-lg-5" id="search_products">
        <div class="row mx-lg-n5" style="width: 30rem;">
          <?php foreach ($products as $product) :           // Loop for searched products
            $productCategorie = getProductCategorie($product['id']);  // For product categorie
            foreach ($productCategorie as $categorie) :     // Loop for categories
          ?>
              <div class="col py-3 px-lg-5">
                <?php include("./template/card.php") ?>
              </div>
          <?php endforeach;
          endforeach; ?>
        </div>
    </header>
<?php
  }
}
include_once("./template/footer.php");
?>
<script src="assets/js/bootstrap.min.js"></script>
</body>

</html>