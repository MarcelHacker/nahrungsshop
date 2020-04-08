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
        <a class="nav-link" href="products.php">Products</a>
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
  $db = getDB();
  if (!$db) {
    die("Error");
  } else {

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
          Cart ()
        </li>
      </ul>
    </nav>
  <?php
    //<?= $cartItems 
  }
}

if (isset($_POST["search"])) {
  $search = $_POST["search_term"];

  $sql = "SELECT * FROM products
        where title like '$search';";
  $products = getProducts($sql);

  if (!$products) {
    echo "Keine Produkte gefunden<br>";
  } else {
    echo "Es wurden folgende Produkte gefunden:<br>";
  ?>
    <header>
      <section class="container px-lg-5" id="search_products">
        <div class="row mx-lg-n5" style="width: 30rem;">
          <?php foreach ($products as $product) : ?>
            <div class="col py-3 px-lg-5">
              <?php include("template/card.php") ?>
            </div>
          <?php endforeach; ?>
        </div>
    </header>
<?php
  }
}
include_once("template/footer.php");
?>
<script src="assets/js/bootstrap.min.js"></script>
</body>

</html>