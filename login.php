<?php
include_once("template/header.php");

$cookie_name = "userId";      // user Id
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
} else {
    if ($_COOKIE[$cookie_name] == "Admin" or $_COOKIE[$cookie_name] == "admin") {
    ?>
        <div class="collapse navbar-collapse menubar">
            <ul class="nav navbar-nav navbar-right">
                <li><a href="admin_startseite.php">Startseite</a></li>
                <li><a href="admin_config.php">Produktkonfiguration</a></li>
                </li>
                <li><a href="login.php">Login</a></li>
                <li><a href="logout.php">Logout</a></li>
        </div>
        </div>
<?php
    } else {
        $db = getDB();
        if (!$db) {
            die("Error");
        } else {
            $res = mysqli_query($db, "select id from user where id='$cookie_name';");
            $userId = mysqli_fetch_array($res, MYSQLI_ASSOC);
            //<?= $cartItems 
            echo "You are allready loged in";
        }
        mysqli_close($db);
    }
}
include_once("template/loginForm.php");

$db = getDB();

if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $statement = $db->prepare("SELECT * FROM users WHERE email = :email");
    $result = $statement->execute(array('email' => $email, 'password' => $password));
    $user = $statement->fetch();

    //Überprüfung des Passworts
    if ($user !== false && password_verify($password, $user['password'])) {
        $_SESSION['userId'] = $user['id'];
        $cookie_name = "userId";

        setcookie("userId", $id, time() + (86400 * 30), "/");
        echo "Erfolg";
        echo "<label>Login erfolgreich! </label>";

        sleep(1.5);    //1,5 warten
        if ($userId == "Admin" or $userId == "admin") {
            header("Location: admin_startseite.php");
        } else {
            header("Location: index.php");
        }
    } else {
        echo "E-Mail oder Passwort war ungültig<br>";
    }
}
include_once("template/footer.php");
?>
<script src="assets/js/bootstrap.min.js"></script>
</body>

</html>