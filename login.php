<?php 
include_once("template/header.php");

$cookie_name="userid";      // user id
if(!isset($_COOKIE[$cookie_name])) //wenn nicht eingeloggt User.php nicht anzeigen
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
                <a class="btn mr-sm-4 btn-outline-dark active" href="login.php">Sign In</a>
      </li>
    </ul>
      <form class="form-inline my-2 my-lg-0" action="search.php" method="GET">
          <input class="form-control mr-sm-1" type="search" placeholder="Search" aria-label="Search">
          <button class="btn btn-outline-success my-2 my-sm-0" type="submit" name="search" id="search">Search</button>
      </form>
    </div>
  </nav>
<?php
} 
else
{
    $db=getDB();
    if(!$db)
    {
        die("Error");
    }
    else
    {
        $res=mysqli_query($db,"select id from user where id='$cookie_name';");
        $userid=mysqli_fetch_array($res,MYSQLI_ASSOC);
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
                Cart ()
            </li>
       </ul>
  </nav>
<?php
//<?= $cartItems 
    }
}
?>


<?php
$db = getDB();
 
if(isset($_GET['login'])) 
{
    $email = $_POST['email'];
    $password = $_POST['password'];
    
    $statement = $db->prepare("SELECT * FROM users WHERE email = :email");
    $result = $statement->execute(array('email' => $email));
    $user = $statement->fetch();
        
    //Überprüfung des Passworts
    if ($user !== false && password_verify($password, $user['password'])) 
    {
        $_SESSION['userid'] = $user['id'];
        die('Login erfolgreich');
        echo "Erfolg";
    } 
    else 
    {
        $errorMessage = "E-Mail oder Passwort war ungültig<br>";
        echo "Eroor";
    }
}
?>

<?php 
if(isset($errorMessage)) 
{
    echo $errorMessage;
}

?>
        <script src="assets/js/bootstrap.min.js"></script>
    </body>
</html>