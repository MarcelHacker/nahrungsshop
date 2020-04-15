<?php
session_start();
include_once("template/header.php");

if (!isLoggedIn()) //wenn nicht eingeloggt User.php nicht anzeigen
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
        <form class="form-inline my-2 my-lg-0" action="search.php" method="POST">
            <input class="form-control mr-sm-1" type="search" placeholder="Search" id="search_term" name="search_term" aria-label="Search">
            <button class="btn btn-outline-success my-2 my-sm-0" type="submit" name="search" id="search">Search</button>
        </form>
        </div>
    </nav>
    <?php
} else {
    if ($_SESSION['userId'] == "0" or $_SESSION['userId'] == "0") {
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
        $userId = $_SESSION['userId'];
        $user = getCurrentUser($userId);
        if (!$user) {
            echo "Error User Id";
        } else {
            echo "You are already logged in<br>";
            echo $user['id'];
        }
        $cartItems = countProductsInCart($userId);

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
                    <a class="btn mr-sm-4 btn-outline-dark" href="login.php">Logout</a>
                </li>
            </ul>
            <form class="form-inline my-2 my-lg-0" action="search.php" method="POST">
                <input class="form-control mr-sm-1" type="search" placeholder="Search" id="search_term" name="search_term" aria-label="Search">
                <button class="btn btn-outline-success my-2 my-sm-0" type="submit" name="search" id="search">Search</button>
            </form>
            </div>
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <i class="fas fa-shopping-cart">
                        <a href="cart.php">Cart (<?= $cartItems ?>)</a>
                    </i>
                </li>
            </ul>
        </nav>
<?php
        // cart insert
    }
}
$showFormular = true;

if (isset($_POST['login'])) {
    $error = false;
    $email = $_POST['email'];
    $password = $_POST['password'];

    $user = getUserWithEmail($email);

    $hash = password_hash($password, PASSWORD_BCRYPT);  // Verschlüsselt das Passoword

    if (!$user) {
        echo "<label>Kein User mit der Email registriert </label><br>";
        $error = true;
    }

    if (strlen($password) == 0) {
        echo "<label>Pasword eingeben!</label><br>";
        $error = true;
    }

    if (!$hash == $user['password']) {
        echo "<label>Falsches Password! </label><br>";
        $error = true;
    }

    echo "User Id = " . $user['id'] . "<br>";

    //Überprüfung des Passworts
    if ($error == false) {
        $_SESSION['userId'] = $user['id'];
        echo "<label>Login erfolgreich! </label><br>";
        $showFormular = false;
    } else {
        echo "E-Mail oder Passwort war ungültig<br>";
    }
}
if ($showFormular == true) {
    include_once("template/loginForm.php");
}
?>
<div class="fixed-bottom">
    <?= include_once("template/footer.php"); ?>
</div>
<script src="assets/js/bootstrap.min.js"></script>
</body>

</html>