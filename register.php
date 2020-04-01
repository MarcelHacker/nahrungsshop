<?php

$cookie_name="userid";      // user id
if(!isset($_COOKIE[$cookie_name])) //wenn nicht eingeloggt User.php nicht anzeigen
{
?>
    <div>
      <h1><span class="badge badge-secondary-" >Brain Food</span></h1>
    </div>
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
    <div>
      <h1><span class="badge badge-secondary-" >Brain Food</span></h1>
    </div>
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
$db = getDB();
 
if(isset($_GET['register'])) 
{
    $error = false;
    $firstname=$_POST["firstname"];
    $lastname=$_POST["lastname"];
    $email=$_POST["email"];
    $adress=$_POST["adress"];
    $houseNumber=$_POST["houseNumber"];
    $city=$_POST["city"];
    $country=$_POST["country"];
    $password=$_POST["password"];
    $confirmPassword=$_POST["confirmPassword"];
    $postCode=$_POST["postCode"];
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
    if($password != $confirmPassword) 
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
        echo 'City is falsen<br>';
        $error = true;
    }
    if(!$country)
    {
        echo 'Choose country<br>';
        $error = true;
    }
    if(!$postCode)
    {
        echo 'Wrong post code<br>';
        $error = true;
    }
  
    //Überprüfe, dass die E-Mail-Adresse noch nicht registriert wurde
    if(!$error) 
    { 
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
        
        $statement = $db->prepare("INSERT INTO users (firstname,lastname,email,adress,houseNumber,city,country,password,postCode,
        birthdate) VALUES (:firstname, :lastname, :email, :adress, :houseNumber, :city, :country, :password, :postCode, :birthdate)");
        $result = $statement->execute(array('firstname' => $firstname,'lastname' => $lastname,'email' => $email,'adress' => $adress,
        'houseNumber' => $houseNumber, 'city' => $city, 'country' => $country, 'password' => $password, 'postCode' => $postCode, 'birthdate' => $birthdate));
        
        if($result) 
        {        
            echo 'Du wurdest erfolgreich registriert';
        } 
        else 
        {
            echo 'Beim Abspeichern ist leider ein Fehler aufgetreten<br>';
        }
    } 
}
?>

   