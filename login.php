<?php 
include_once("template/header.php");

$cookie_name="userId";      // user Id
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
	if($_COOKIE[$cookie_name]=="Admin" or $_COOKIE[$cookie_name]=="admin")
	{
?>	
    <div class="collapse navbar-collapse menubar">
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="admin_startseite.php">Startseite</a></li>				
					<li><a href="admin_config.php">Produktkonfiguration</a></li>
					</li><li><a href="login.php">Login</a></li>
					<li><a href="logout.php">Logout</a></li>
                </div>
		</div>
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
            $userId=mysqli_fetch_array($res,MYSQLI_ASSOC);
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
        echo "You are allready loged in";
         }
    }
}
?>
<div class="container" style="background-color: #e3f2fd;">
    <div class="dropdown">
      <form class="px-4 py-3" action="login.php" method="POST">
          <div class="form-group">
              <label for="email">Email address</label>
              <input type="email" class="form-control" name="email" id="email" placeholder="email@example.com">
          </div>
          <div class="form-group">
              <label for="password">Password</label>
              <input type="password" class="form-control" name="password" id="password" placeholder="Password">
          </div>
          <div class="form-check">
              <input type="checkbox" class="form-check-input" id="dropdownCheck">
              <label class="form-check-label" for="dropdownCheck">
                    Remember me
              </label>
          </div>
              <button type="submit" name="login" class="btn btn-primary">Sign In</button>
        </form>
            <div class="dropdown">
                    <a class="dropdown-item" href="register.php">New around here? Sign up</a>
                 <a class="dropdown-item" href="passwordForgotten.php">Forgot password?</a>
            </div>   
        </div> 
    </div>
<?php
$db = getDB();
 
if(isset($_POST['login'])) 
{
    $email = $_POST['email'];
    $password = $_POST['password'];
    
    $statement = $db->prepare("SELECT * FROM users WHERE email = :email");
    $result = $statement->execute(array('email' => $email));
    $user = $statement->fetch();
        
    //Überprüfung des Passworts
    if ($user !== false && password_verify($password, $user['password'])) 
    {
        $_SESSION['userId'] = $user['id'];
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