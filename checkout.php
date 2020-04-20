<?php

/**
 * A summary informing the user what the associated element does.
 *
 * A *description*, that can span multiple lines, to go _in-depth_ into the details of this element
 * and to provide some background information or textual references.
 *
 *
 * 
 */
session_start();        // For session variable  
include_once("./template/header.php");      // For functions
$userId = $_SESSION['userId'];          // Get user id

if (!isLoggedIn()) {    // Is the user logged in?
    header("Location: login.php");  // Got to login
    exit;               // Prevents load this page
} else {
    $user = getCurrentUser($userId);
    if (!$user) {   // Check if user with this id exists
        echo "Error user Id <br>";
        die();
    } else {
        $countCartItems = countProductsInCart($userId); // Count cart items from user
?>

        <body>
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
                <form class="form-inline my-2 my-lg-0" action="search.php" method="POST">
                    <input class="form-control mr-sm-1" type="search" placeholder="Search" id="search_term" name="search_term" aria-label="Search">
                    <button class="btn btn-outline-success my-2 my-sm-0" type="submit" name="search" id="search">Search</button>
                </form>
                </div>
            </nav>
            <?php   // Check cart from user
            $found = getCartItemsForUserId($user['id']); // Get all items in cart
            if (!$found) {              // No items found?
            ?>
                <div class="alert alert-danger" role="alert">
                    <h4 class="alert-heading">No products in cart found.</h4>
                    <p>Add products to your cart</p>
                </div>
            <?php
                die();
            }
        }
    }
    $db = getDB();  // database connection
    if (!$db) {
        echo "Error database connection<br>";
        die();
    }
    $user = getCurrentUser($userId);    // Gets user data
    $showCheckout = true;

    if (isset($_POST["order"])) {   // Make a product order
        $error = false;
        $firstname = $_POST["firstname"];
        $lastname = $_POST["lastname"];
        $email = $_POST["email"];
        $address = $_POST["address"];
        $housenumber = $_POST["housenumber"];
        $city = $_POST["city"];
        $country = $_POST["country"];
        $postcode = $_POST["postcode"];

        // Validate Data
        if ($email != $user['email']) {      // Need to update email?
            $existingUser = getUserWithEmail($email);
            if ($existingUser) {             // An other user allready has the same email
                echo 'Email address allready used<br>';
            } else {                        // Email update possible
                $sql = "UPDATE users SET email = :email
            WHERE id = :userid";
                $statement = $db->prepare($sql);

                $result = $statement->execute(array('email' => $email, 'userid' => $existingUser['id']));
                if (!$result) { // Error?
                    echo "Error update Email address<br>";
                    $error = true;
                }
            }
        }
        if ($firstname != $user['firstname']) { // Need to update firstname?
            $sql = "UPDATE users SET firstname = :firstname
        WHERE id = :userid";
            $statement = $db->prepare($sql);

            $result = $statement->execute(array('firstname' => $firstname, 'userid' => $user['id']));
            if (!$result) { // Error?
                echo "Error update firstname<br>";
                $error = true;
            } else {
                echo "firstname updated<br>";
            }
        }
        if ($lastname != $user['lastname']) { // Need to update lastname?
            $sql = "UPDATE users SET lastname = :lastname
        WHERE id = :userid";
            $statement = $db->prepare($sql);

            $result = $statement->execute(array('lastname' => $lastname, 'userid' => $user['id']));
            if (!$result) { // Error?
                echo "Error update lastname<br>";
                $error = true;
            } else {
                echo "Lastname updated<br>";
            }
        }
        if ($address != $user['address']) { // Need to update address?
            $sql = "UPDATE users SET address = :address
        WHERE id = :userid";
            $statement = $db->prepare($sql);

            $result = $statement->execute(array('address' => $address, 'userid' => $user['id']));
            if (!$result) { // Error?
                echo "Error update address<br>";
                $error = true;
            } else {
                echo "Address updated<br>";
            }
        }
        if ($housenumber != $user['housenumber']) { // Need to update housenumber?
            $sql = "UPDATE users SET housenumber = :housenumber
        WHERE id = :userid";
            $statement = $db->prepare($sql);

            $result = $statement->execute(array('housenumber' => $housenumber, 'userid' => $user['id']));
            if (!$result) { // Error?
                echo "Error update housenumber<br>";
                $error = true;
            } else {
                echo "Housenumber updated<br>";
            }
        }
        if ($country != $user['country']) { // Need to update country?
            $sql = "UPDATE users SET country = :country
        WHERE id = :userid";
            $statement = $db->prepare($sql);

            $result = $statement->execute(array('country' => $country, 'userid' => $user['id']));
            if (!$result) { // Error?
                echo "Error update country<br>";
                $error = true;
            } else {
                echo "Country updated<br>";
            }
        }
        if ($city != $user['city']) {   // Need to update city?
            $sql = "UPDATE users SET city = :city
        WHERE id = :userid";
            $statement = $db->prepare($sql);

            $result = $statement->execute(array('city' => $city, 'userid' => $user['id']));
            if (!$result) { // Error?
                echo "Error update city<br>";
                $error = true;
            } else {
                echo "City updated<br>";
            }
        }
        if ($postcode != $user['postcode']) {  // Need to update postcode?
            $sql = "UPDATE users SET postcode = :postcode
        WHERE id = :userid";
            $statement = $db->prepare($sql);

            $result = $statement->execute(array('postcode' => $postcode, 'userid' => $user['id']));
            if (!$result) { // Error?
                echo "Error update postcode<br>";
                $error = true;
            } else {
                echo "Postcode updated<br>";
            }
        }

        //No error, we can set an order
        if (!$error) {

            $orderNumber = rand(1, 999999999);  // rand() get random integer between min and max
            // Items in cart
            $sameOrders = "SELECT * orders      
                        WHERE order_no = :ord_no";  // Check for same order numbers
            $stmt = $db->prepare($sameOrders);
            $orderWithSameNumber = $stmt->execute(array('ord_no' => $orderNumber));

            if ($orderWithSameNumber) {     // Are there same order numbers?
                while ($orderWithSameNumber['order_no'] == $orderNumber) {
                    $orderNumber = $orderNumber + 1;    // Increment for another number
                }                           // Now we have a unused ordernumber
            }
            // Get items from cart in order
            $sql = "INSERT INTO orders (order_no,user_id,product_id,quantity) 
                    VALUES (:order_no,:user_id,:product_id,:quantity)";
            $statement = $db->prepare($sql);

            foreach ($found as $orders) {         // For all items in cart
                $result = $statement->execute(array(
                    'order_no' => $orderNumber, 'user_id' => $orders['user_id'],
                    'product_id' => $orders['product_id'], 'quantity' => $orders['quantity']
                ));
                if ($result) {              // Check for errors and get order number
                    echo "Product: " . $orders["product_id"] . " ordered<br>";
                } else {
                    echo "Error product Id: " . $orders["product_id"] . "from user Id: " . $orders["user_id"] . "<br>";
                }
            }
            $sql = "SELECT order_no FROM orders 
                    WHERE order_no = :ordernumber"; // Check if order is generated
            $statement = $db->prepare($sql);
            $ordered = $statement->execute(array(
                'ordernumber' => $orderNumber
            ));
            if ($ordered) {          // Check order and order number
            ?>
                <div class="alert alert-success" role="alert">
                    <h4 class="alert-heading">Thank you for your order!</h4>
                    <p>Your ordernumber is: #<?= $orderNumber ?></p>
                </div>
                <?php
                $sql = "DELETE FROM cart
                        WHERE user_id = :userid";   // Remember to delete ordered items from cart
                $statement = $db->prepare($sql);
                $clearCart = $statement->execute(array(
                    'userid' => $user['id']
                ));
                if (!$clearCart) {  // Error cart clearing?
                    echo "Error cart clearing<br>";
                }
                $showCheckout = false;  // Hide Checkout formular
            } else {
                ?>
                <div class="alert alert-danger" role="alert">
                    <h4 class="alert-heading">Excuse me, something went wrong with your order.</h4>
                    <p>Try it again</p>
                </div>
    <?php
            }
        }
    }
    if ($showCheckout == true) {    // Hide Formular?
        include_once("./template/checkoutPage.php");
    }
    ?>
    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script>
        window.jQuery || document.write('<script src="../../assets/js/vendor/jquery-slim.min.js"><\/script>')
    </script>
    <script src="../../assets/js/vendor/popper.min.js"></script>
    <script src="../../dist/js/bootstrap.min.js"></script>
    <script src="../../assets/js/vendor/holder.min.js"></script>
    <script>
        // Example starter JavaScript for disabling form submissions if there are invalid fields
        (function() {
            'use strict';

            window.addEventListener('load', function() {
                // Fetch all the forms we want to apply custom Bootstrap validation styles to
                var forms = document.getElementsByClassName('needs-validation');

                // Loop over them and prevent submission
                var validation = Array.prototype.filter.call(forms, function(form) {
                    form.addEventListener('submit', function(event) {
                        if (form.checkValidity() === false) {
                            event.preventDefault();
                            event.stopPropagation();
                        }
                        form.classList.add('was-validated');
                    }, false);
                });
            }, false);
        })();
    </script>
        </body>

        </html>