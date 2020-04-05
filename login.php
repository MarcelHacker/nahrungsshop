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
            $sql = "select id from user where id='$cookie_name';";
            $res = mysqli_query($db, $sql);
            $userId = mysqli_fetch_array($res);
            //<?= $cartItems 
            echo "You are already logged in";
        }
    }
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
include_once("template/loginForm.php");

$db = getDB();
if (!$db) {
    echo "Error database connection";
    die();
}

if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $statement = $db->prepare("SELECT * FROM users WHERE email = :email");
    $result = $statement->execute(array('email' => $email));
    $user = $statement->fetch();    // User schon vorhanden?

    if (!$user) {
        echo "<label>Kein User mit der Email registriert </label>";
    }

    if (strlen($password) == 0) {
        echo "<label>Pasword eingeben!</label>";
    } else {
        $hash = password_hash($password, PASSWORD_BCRYPT);  // Verschlüsselt das Passoword
    }

    if (!$hash == $user['password']) {
        echo "<label>Falsches Password! </label>";
    }

    //Überprüfung des Passworts
    if (!$user == false && $hash == $user['password']) {
        session_start();
        $_SESSION['userId'] = $user['id'];

        echo "<label>Login erfolgreich! </label>";
        header(" Location: user.php");
    } else {
        echo "E-Mail oder Passwort war ungültig<br>";
    }
}
include_once("template/footer.php");
?>
<script src="assets/js/bootstrap.min.js"></script>
</body>

</html>