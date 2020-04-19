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
    $userId = $_SESSION['userId'];  // Check is user id is registered
    $user = getCurrentUser($userId);
    if (!$user) {
        echo "Error User Id";   // No user with this id registered
        die();
    }
    $countCartItems = countProductsInCart($userId); // Amount of cart items from user
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
                    <a href="cart.php">Cart (<?= $countCartItems ?>)</a>
                </i>
            </li>
        </ul>
    </nav>
<?php
}
$showFormular = true;

if (isset($_POST['login'])) {   // User loging in?
    $error = false;
    $email = $_POST['email'];
    $password = $_POST['password'];

    $user = getUserWithEmail($email);   // Check if Email already registered

    $hash = password_hash($password, PASSWORD_BCRYPT);  // encrypt password

    if (!$user) {   // No user with this email?
        echo "<label>Kein User mit der Email registriert </label><br>";
        $error = true;
    }

    if (strlen($password) == 0) { // Password typed in?
        echo "<label>Pasword eingeben!</label><br>";
        $error = true;
    }

    if (!$hash == $user['password']) { // Check is passoword matches
        echo "<label>Falsches Password! </label><br>";
        $error = true;
    }

    if (!$error) { // Now we can log in user
        $_SESSION['userId'] = $user['id'];  // Sets user id in session variable
        $showFormular = false;
        sleep(0.5);   // waits 0,5 seconds
        header("Location: index.php"); // Got to home
        exit;   // Prevents loading page
    } else {
        echo "Email or password is wrong<br>";
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