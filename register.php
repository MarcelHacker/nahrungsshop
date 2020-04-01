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
                <a class="nav-link" href="products.php">Products</a>
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
  </nav>
  <!--cart insert-->

  <?php
    }
    echo "You are already logged in";
	sleep (1.5);	//1,5 warten
	header("Location: index.php");
}
?>
<form action="register.php" method="POST">
  <div class="container" style="background-color: #e3f2fd;">
    <div class="form-row">
        <div class="form-group col-md-6">
            <label for="inputFisrtname4">Firstname</label>
            <input type="text" class="form-control" name="firstname" id="firstname" placeholder="Max">
        </div>
        <div class="form-group col-md-6">
            <label for="lastname">Lastname</label>
            <input type="text" class="form-control"  name="lastname" id="lastname" placeholder="Mustermann">
        </div>
        <div class="form-group col-md-6">
            <label for="email">Email</label>
            <input type="email" class="form-control" name="email" id="email" placeholder="Email">
        </div>
        <div class="form-group col-md-6">
            <label for="password">Password</label>
            <input type="password" class="form-control" name="password" id="password" placeholder="Password">
        </div>
        <div class="form-group col-md-6">
            <label for="confrimPassword">Confirm Password</label>
            <input type="password" class="form-control" name="confirmpassword" id="confirmpassword" placeholder="Confirm Password">
        </div>
        <div class="form-group col-md-6">
            <label for="birthdate">Birthdate</label>
            <input type="date" class="form-control" name="birthdate" id="birthdate" placeholder="">
        </div>
        <div class="form-group col-md-6">
            <label for="inputAddress2">Address</label>
            <input type="text" class="form-control" name="adress" id="adress" placeholder="Hufeisengasse">
        </div>
        <div class="form-group col-md-1">
            <label for="houseNumber">Housenumber</label>
            <input type="number" class="form-control" name="housenumber" id="housenumber" placeholder="1">
        </div>
      </div>
    
    <div class="form-row">
      <div class="form-group col-md-6">
          <label for="city">City</label>
          <input type="text" class="form-control" name="city" id="city" placeholder="Guntersdorf">
      </div>
      <div class="form-group col-md-4">
          <label for="country">State</label>
          <select name="country" id="country" class="form-control">
              <option selected>Choose...</option>
              <option value="austria">Austria</option>
              <option value="united kingdom">United Kingdom</option>
              <option value="china">China</option>
      </select>
      </div>
      <div class="form-group col-md-2">
          <label for="postCode">Zip</label>
          <input type="number" class="form-control" name="postcode" id="postcode" placeholder="1234">
      </div>
    </div>
    <div class="form-group">
      <div class="form-check">
          <input class="form-check-input" type="checkbox" id="checkRobot">
            <label class="form-check-label" for="checkRobot">
                I am not a robot
            </label>
          </div>
      </div>
            <button type="submit"  name="register" class="btn btn-primary">Sign Up</button>
    </div>
  </form>
<?php
if(isset($_POST['register'])) 
{
    $error = false;
    $firstname=$_POST["firstname"];
    $lastname=$_POST["lastname"];
    $email=$_POST["email"];
    $adress=$_POST["adress"];
    $housenumber=$_POST["housenumber"];
    $city=$_POST["city"];
    $country=$_POST["country"];
    $password=$_POST["password"];
    $confirmpassword=$_POST["confirmpassword"];
    $postcode=$_POST["postcode"];
    $birthdate=$_POST["birthdate"];
  
    // Validate Data
    if(!filter_var($email, FILTER_VALIDATE_EMAIL)) 
    {
        echo 'Bitte eine gültige E-Mail-Adresse eingeben<br>';
        $error = true;
    }
    if(!$firstname)
    {
        echo 'Wrong firstname<br>';
        $error = true;
    }
    if(!$lastname)
    {
        echo 'Wrong lastname<br>';
        $error = true;
    }     
    if(strlen($password) == 0) 
    {
        echo 'Bitte ein Passwort angeben<br>';
        $error = true;
    }
    if($password != $confirmpassword) 
    {
        echo 'Die Passwörter müssen übereinstimmen<br>';
        $error = true;
    }
    if(!$birthdate)
    {
        echo 'Birthdate is false<br>';
        $error = true;
    }
    if(!$city)
    {
        echo 'City is false<br>';
        $error = true;
    }
    if(!$country)
    {
        echo 'Choose country<br>';
        $error = true;
    }
    if(!$postcode)
    {
        echo 'Wrong post code<br>';
        $error = true;
    }
  
    //Überprüfe, dass die E-Mail-Adresse noch nicht registriert wurde
    if(!$error) 
    {
        $db= getDB(); 
        $statement = $db->prepare("SELECT * FROM users WHERE email = :email");
        $result = $statement->execute(array('email' => $email));
        $email = $statement->fetch();
        
        if($email !== false) 
        {
            echo 'Diese E-Mail-Adresse ist bereits vergeben<br>';
            $error = true;
        }    
    }
    
    //Keine Fehler, wir können den Nutzer registrieren
    if(!$error) 
    {    
       //$passwort_hash = password_hash($password, PASSWORD_DEFAULT);
        
        $statement = $db->prepare("INSERT INTO users (firstname,lastname,email,adress,housenumber,city,country,password,postcode,
        birthdate) VALUES (:firstname, :lastname, :email, :adress, :housenumber, :city, :country, :password, :postcode, :birthdate)");
        $result = $statement->execute(array('firstname' => $firstname,'lastname' => $lastname,'email' => $email,'adress' => $adress,
        'housenumber' => $housenumber, 'city' => $city, 'country' => $country, 'password' => $password, 'postcode' => $postcode, 'birthdate' => $birthdate));
        
        if($result) 
        {     
            $statement = $db->prepare("SELECT id FROM users WHERE email = :email");
            $result = $statement->execute(array('email' => $email));
            $userid = $statement->fetch();   
            echo 'Du wurdest erfolgreich registriert';

            setcookie("userid", $userid);
			sleep (1.5);	//1,5 warten
			header("Location: index.php"); 
        } 
        else 
        {
            echo 'Beim Abspeichern ist leider ein Fehler aufgetreten<br>';
        }
    } 
}
?>
        <script src="assets/js/bootstrap.min.js"></script>
    </body>
</html>

   