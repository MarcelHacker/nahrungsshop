<?php
session_start();
include_once("template/header.php");

if (!isset($_SESSION['userId'])) //wenn nicht eingeloggt User.php nicht anzeigen
{
    echo "Please login for your cart<br>";
    time_sleep_until(3);
    header("Location: login.php");
} else {
    $userId = $_SESSION['userId'];
    $user = getCurrentUser($userId);    // User vorhanden?
    if (!$user) {                     // Falsche User Id ?
        echo "Error User Id <br>";
    } else {
        $cartItems = countProductsInCart($userId);
?>
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <ul class="nav nav-tabs">
                <li class="nav-item">
                    <a class="nav-link active" href="index.php">Home</a>
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
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    Cart (<?= $cartItems ?>)
                </li>
            </ul>
        </nav>
<?php
    }
}

include_once("template/footer.php");
?>
<script src="assets/js/bootstrap.min.js"></script>
</body>

</html>