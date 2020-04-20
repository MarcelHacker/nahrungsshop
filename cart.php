<?php

/**
 * Php file for the user cart
 * 
 * Used for the website
 * 
 */
session_start();        // For session variable  
include_once("./template/header.php");      // For functions

if (!isLoggedIn()) //wenn nicht eingeloggt User.php nicht anzeigen
{
    header("Location: login.php");
    exit;
} else {
    $userId = $_SESSION['userId'];
    $user = getCurrentUser($userId);    // User vorhanden?
    if (!$user) {                     // Falsche User Id ?
        echo "Error User Id <br>";
    } else {
        $countCartItems = countProductsInCart($userId);
?>
        <!-- Navigation for Brain Food -->
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
                    <i class="fas fa-shopping-cart">
                        <a href="cart.php">Cart (<?= $countCartItems ?>)</a>
                    </i>
                </li>
            </ul>
        </nav>
        <!-- Navigation for Brain Food -->
<?php
        $cartItems = getCartItemsForUserId($userId); // All items in cart
        $cartSum = getCartSumForUserId($userId);     // Total price
        include_once("template/cartPage.php");       // Cenerates cart page
    }
}

if (isset($_GET["plus"])) {     // Insrease quanity of a product in cart
    if (!empty($_GET["plus"])) {
        $userId = $_SESSION["userId"];  // Gets user id
        $productId = $_GET["plus"];     // Gets product id
        $result = addProductToCart($userId, $productId);
        if (!$result) {
            echo "Error add product<br>";
        }
        header("Location: cart.php");   // Relaods the cart
    } else {
        echo "No product selected<br>";
    }
}
if (isset($_GET["del"])) {      // Completely deletes a product from cart
    if (!empty($_GET["del"])) {
        $userId = $_SESSION["userId"];
        $productId = $_GET["del"];
        $result = deleteProductFromCart($userId, $productId);
        if (!$result) {
            echo "Error delete product<br>";
        }
        header("Location: cart.php");  // Reloads the cart
    } else {
        echo "No product selected<br>";
    }
}
include_once("./template/footer.php"); // Site footer
?>
<script src="assets/js/bootstrap.min.js"></script>
</body>

</html>