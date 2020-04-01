<?php
include_once("template/header.php");
//$userId = getCurrentUserId();
//$cartItems = countProductsInCart($userId); 

$cookie_name = "userid";      // user id
if (!isset($_COOKIE[$cookie_name])) //wenn nicht eingeloggt User.php nicht anzeigen
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
  $db = getDB();
  if (!$db) {
    die("Error");
  } else {
    $res = mysqli_query($db, "select id from user where id='$cookie_name';");
    $userid = mysqli_fetch_array($res, MYSQLI_ASSOC);
  ?>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
      <ul class="nav nav-tabs">
        <li class="nav-item">
          <a class="nav-link" href="index.php">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="products.php">Products</a>';
        </li>
        <li class="nav-item">
          <a class="nav-link active" href="about.php">About</a>';
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
?>
<div class="container">
  <div class="row row-cols-1 row-cols-md-2">
    <div class="card mb-5">
      <div class="row no-gutters">
        <div class="col-md-14">
          <img src="https://i.dietdoctor.com/wp-content/uploads/2018/08/GettyImages-876656828.jpg?auto=compress%2Cformat&w=800&h=533&fit=crop" class="card-img" alt="image">
        </div>
        <div class="col-md-14">
          <div class="card-body">
            <h5 class="card-title">Healthy Eating</h5>
            <p class="card-text">Eating a healthy diet is not about strict limitations, staying unrealistically thin,
              or depriving yourself of the foods you love.
              Rather, it’s about feeling great, having more energy, improving your health, and boosting your mood.</p>
          </div>
        </div>
      </div>
    </div>
  </div>
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
  <?php
  include_once("template/footer.php");
  ?>

  <script src="assets/js/bootstrap.min.js"></script>
  </body>

  </html>