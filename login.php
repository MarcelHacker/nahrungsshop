<?php
session_start(); 


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
<html>
    <body>
<?php 
if(isset($errorMessage)) 
{
    echo $errorMessage;
}

?>
        <script src="assets/js/bootstrap.min.js"></script>
    </body>
</html>