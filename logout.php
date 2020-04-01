<?php
session_unset();
session_destroy();
include_once("template/header.php");

header("Location: index.php?logout=true");

$cookie_name = "userid";      // user id
if (!isset($_COOKIE[$cookie_name])) //wenn nicht eingeloggt User.php nicht anzeigen
{
?>
  <div>
    <h1><span class="badge badge-secondary-">Brain Food</span></h1>
  </div>
  <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <ul class="nav nav-tabs">
      <li class="nav-item">
        <a class="nav-link active" href="index.php">Home</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="products.php">Products</a>';
      </li>
      <li class="nav-item">
        <a class="nav-link" href="about.php">About</a>';
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
    $res = mysqli_query($db, "select id from user where id='$cookie_name';");
    $userid = mysqli_fetch_array($res, MYSQLI_ASSOC);
  ?>
    <div>
      <h1><span class="badge badge-secondary-">Brain Food</span></h1>
    </div>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
      <ul class="nav nav-tabs">
        <li class="nav-item">
          <a class="nav-link active" href="index.php">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="products.php">Products</a>';
        </li>
        <li class="nav-item">
          <a class="nav-link" href="about.php">About</a>';
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
    <script src="assets/js/bootstrap.min.js"></script>
    </body>

    </html>
<?php
  }
}
include_once("template/footer.php");
setcookie("userId", "", time() - (86400 * 30), "/");
sleep(1.5); //1,5s warten
header("Location: index.php");
?>