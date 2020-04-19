<?php
session_start();
include_once("template/header.php");
$userId = $_SESSION['userId'];
$showCheckout = true;

if (!isLoggedIn()) {
    header("Location: login.php");
    exit;
} else {
    $user = getCurrentUser($userId);
    if (!$user) {
        echo "Error user Id <br>";
        die();
        exit;
    } else {
        $countCartItems = countProductsInCart($userId);

?>

        <body>

    <?php
    }
}
$db = getDB();
if (!$db) {
    echo "Error database connection<br>";
    die();
}
$user = getCurrentUser($userId);

if (isset($_POST["order"])) {
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
    if ($email != $user['email']) {
        $existingUser = getUserWithEmail($email);
        if ($existingUser) {
            echo 'Email address allready used<br>';
        } else {
            $sql = "UPDATE users SET email = :email
            WHERE id = :userid";
            $statement = $db->prepare($sql);

            $result = $statement->execute(array('email' => $email, 'userid' => $existingUser['id']));
            if (!$result) {
                echo "Error update Email address<br>";
                $error = true;
            }
        }
    }
    if ($firstname != $user['firstname']) {
        $sql = "UPDATE users SET firstname = :firstname
        WHERE id = :userid";
        $statement = $db->prepare($sql);

        $result = $statement->execute(array('firstname' => $firstname, 'userid' => $user['id']));
        if (!$result) {
            echo "Error update firstname<br>";
            $error = true;
        } else {
            echo "firstname updated<br>";
        }
    }
    if ($lastname != $user['lastname']) {
        $sql = "UPDATE users SET lastname = :lastname
        WHERE id = :userid";
        $statement = $db->prepare($sql);

        $result = $statement->execute(array('lastname' => $lastname, 'userid' => $user['id']));
        if (!$result) {
            echo "Error update lastname<br>";
            $error = true;
        } else {
            echo "Lastname updated<br>";
        }
    }
    if ($address != $user['address']) {
        $sql = "UPDATE users SET address = :address
        WHERE id = :userid";
        $statement = $db->prepare($sql);

        $result = $statement->execute(array('address' => $address, 'userid' => $user['id']));
        if (!$result) {
            echo "Error update address<br>";
            $error = true;
        } else {
            echo "Address updated<br>";
        }
    }
    if ($housenumber != $user['housenumber']) {
        $sql = "UPDATE users SET housenumber = :housenumber
        WHERE id = :userid";
        $statement = $db->prepare($sql);

        $result = $statement->execute(array('housenumber' => $housenumber, 'userid' => $user['id']));
        if (!$result) {
            echo "Error update housenumber<br>";
            $error = true;
        } else {
            echo "Housenumber updated<br>";
        }
    }
    if ($country != $user['country']) {
        $sql = "UPDATE users SET country = :country
        WHERE id = :userid";
        $statement = $db->prepare($sql);

        $result = $statement->execute(array('country' => $country, 'userid' => $user['id']));
        if (!$result) {
            echo "Error update country<br>";
            $error = true;
        } else {
            echo "Country updated<br>";
        }
    }
    if ($city != $user['city']) {
        $sql = "UPDATE users SET city = :city
        WHERE id = :userid";
        $statement = $db->prepare($sql);

        $result = $statement->execute(array('city' => $city, 'userid' => $user['id']));
        if (!$result) {
            echo "Error update city<br>";
            $error = true;
        } else {
            echo "City updated<br>";
        }
    }
    if ($postcode != $user['postcode']) {
        $sql = "UPDATE users SET postcode = :postcode
        WHERE id = :userid";
        $statement = $db->prepare($sql);

        $result = $statement->execute(array('postcode' => $postcode, 'userid' => $user['id']));
        if (!$result) {
            echo "Error update postcode<br>";
            $error = true;
        } else {
            echo "Postcode updated<br>";
        }
    }

    //No error, we can set an order
    if (!$error) {
        $found = getCartItemsForUserId($user['id']); // Get all items in cart
        if (!$found) {              // No items found?
            echo "Error no products in cart found<br>";
            die();
        } else {    // Items in cart
            $orderNumber = rand(1, 999999999);  // rand() get random integer between min and max

            $sameOrders = "SELECT * orders
                        WHERE order_no = :ord_no";
            $stmt = $db->prepare($sameOrders);
            $orderWithSameNumber = $statement->execute(array('ord_no' => $orderNumber));

            if ($orderWithSameNumber) {     // Are there same order numbers?
                while ($orderWithSameNumber['order_no'] == $orderNumber) {
                    $orderNumber = $orderNumber + 1;    // Increment for another number
                }
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
                if ($result) {          // Check for errors and get order number
                    echo "Product: " . $orders["product_id"] . " ordered<br>";
                } else {
                    echo "Error product Id: " . $orders["product_id"] . "from user Id: " . $orders["user_id"] . "<br>";
                }
            }
            $sql = "SELECT order_no FROM orders 
                    WHERE order_no = :ordernumber";
            $statement = $db->prepare($sql);
            $ordered = $statement->execute(array(
                'ordernumber' => $orderNumber
            ));

            if ($ordered) {          // Check order number
                echo "<label>Thank you for your order!</label></br>";
                echo "<p>Your ordernumber is: #" . $orderNumber . "</p><br>";
                $showCheckout = false;
            } else {
                echo 'Excuse me, something went wrong<br>';
            }
        }
    }
}
if ($showCheckout == true) {
    include_once("template/checkoutPage.php");
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