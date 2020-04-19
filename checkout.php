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
        if ($showCheckout = true) {
?>

            <body>
                <div class="container">
                    <div class="row">
                        <div class="col-md-4 order-md-2 mb-4">
                            <h4 class="d-flex justify-content-between align-items-center mb-3">
                                <span class="text-muted">Your cart</span>
                                <span class="badge badge-secondary badge-pill"><?= $countCartItems ?></span>
                            </h4>
                            <ul class="list-group mb-3">

                                <?php
                                $cartSum = getCartSumForUserId($userId);
                                $cartItems = getCartItemsForUserId($userId);
                                foreach ($cartItems as $cartItem) :
                                ?>
                                    <li class="list-group-item d-flex justify-content-between lh-condensed">
                                        <div>
                                            <h6 class="my-0"><?= $cartItem["title"] ?></h6>
                                            <small class="text-muted"><?= $cartItem["description"] ?></small>
                                        </div>
                                        <span class="text-muted"><?= $cartItem["price"] ?> €</span>
                                    </li>
                                <?php endforeach; ?>
                                <li class="list-group-item d-flex justify-content-between">
                                    <span>Total (EURO)</span>
                                    <strong><?= number_format($cartSum, 2, ",", " ") ?> €</strong>
                                </li>
                            </ul>
                        </div>
                        <div class="col-md-8 order-md-1">
                            <h4 class="mb-3">Billing address</h4>
                            <form class="needs-validation" novalidate action="checkout.php" method="POST">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="firstName">First name</label>
                                        <input type="text" class="form-control" name="firstname" id="firstName" placeholder="" value="<?= $user["firstname"] ?>" required>
                                        <div class="invalid-feedback">
                                            Valid first name is required.
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="lastName">Last name</label>
                                        <input type="text" class="form-control" name="lastname" id="lastName" placeholder="" value="<?= $user["lastname"] ?>" required>
                                        <div class="invalid-feedback">
                                            Valid last name is required.
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="email">Email <span class="text-muted"></span></label>
                                    <input type="email" class="form-control" name="email" id="email" value="<?= $user["email"] ?>" placeholder="">
                                    <div class="invalid-feedback">
                                        Please enter a valid email address for shipping updates.
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="inputAddress2">Address</label>
                                    <input type="text" class="form-control" name="address" id="address" value="<?= $user["address"] ?>" placeholder="" required>
                                    <div class="invalid-feedback">
                                        Please enter your shipping address.
                                    </div>
                                </div>
                                <div class="mb-1 col-2">
                                    <label for="houseNumber">Housenumber</label>
                                    <input type="text" class="form-control" name="housenumber" id="housenumber" value="<?= $user["housenumber"] ?>" placeholder="">
                                </div>

                                <div class="row p-1">
                                    <div class="col-md-5 mb-3">
                                        <label for="country">Country</label>
                                        <select class="custom-select d-block w-100" id="country" required>
                                            <option value="<?= $user["country"] ?>"><?= $user["country"] ?></option>
                                            <option value="austria">Austria</option>
                                            <option value="united kingdom">United Kingdom</option>
                                            <option value="china">China</option>
                                            <option value="united states">United States</option>
                                            <option value="schwitzerland">Schwitzerland</option>
                                            <option value="germany">Germany</option>
                                        </select>
                                        <div class="invalid-feedback">
                                            Please select a valid country.
                                        </div>
                                    </div>

                                    <div class="col-md-4 mb-3">
                                        <label for="city">City</label>
                                        <input type="text" class="form-control" name="city" id="city" value="<?= $user["city"] ?>" placeholder="Guntersdorf" required>
                                        <div class="invalid-feedback">
                                            Please provide a valid city.
                                        </div>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <label for="zip">Zip</label>
                                        <input type="text" class="form-control" id="zip" value="<?= $user["postcode"] ?>" placeholder="" required>
                                        <div class="invalid-feedback">
                                            Zip code required.
                                        </div>
                                    </div>
                                </div>
                                <hr class="mb-4">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="same-address">
                                    <label class="custom-control-label" for="same-address">Shipping address is the same as my billing address</label>
                                </div>
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="save-info">
                                    <label class="custom-control-label" for="save-info">Save this information for next time</label>
                                </div>
                                <hr class="mb-4">

                                <h4 class="mb-3">Payment</h4>

                                <div class="d-block my-3">
                                    <div class="custom-control custom-radio">
                                        <input id="credit" name="paymentMethod" type="radio" class="custom-control-input" checked required>
                                        <label class="custom-control-label" for="credit">Credit card</label>
                                    </div>
                                    <div class="custom-control custom-radio">
                                        <input id="debit" name="paymentMethod" type="radio" class="custom-control-input" required>
                                        <label class="custom-control-label" for="debit">Debit card</label>
                                    </div>
                                    <div class="custom-control custom-radio">
                                        <input id="paypal" name="paymentMethod" type="radio" class="custom-control-input" required>
                                        <label class="custom-control-label" for="paypal">Paypal</label>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="cc-name">Name on card</label>
                                        <input type="text" class="form-control" id="cc-name" placeholder="" required>
                                        <small class="text-muted">Full name as displayed on card</small>
                                        <div class="invalid-feedback">
                                            Name on card is required
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="cc-number">Credit card number</label>
                                        <input type="text" class="form-control" id="cc-number" placeholder="" required>
                                        <div class="invalid-feedback">
                                            Credit card number is required
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3 mb-3">
                                        <label for="cc-expiration">Expiration</label>
                                        <input type="text" class="form-control" id="cc-expiration" placeholder="" required>
                                        <div class="invalid-feedback">
                                            Expiration date required
                                        </div>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <label for="cc-expiration">CVV</label>
                                        <input type="text" class="form-control" id="cc-cvv" placeholder="" required>
                                        <div class="invalid-feedback">
                                            Security code required
                                        </div>
                                    </div>
                                </div>
                                <hr class="mb-4">
                                <button class="btn btn-primary btn-lg btn-block" name="order" type="submit">Buy</button>
                            </form>
                        </div>
                    </div>

                    <footer class="my-5 pt-5 text-muted text-center text-small">
                        <p class="mb-1">&copy; 2020 Brain Food</p>
                        <ul class="list-inline">
                            <li class="list-inline-item"><a href="#">Privacy</a></li>
                            <li class="list-inline-item"><a href="#">Terms</a></li>
                            <li class="list-inline-item"><a href="#">Support</a></li>
                        </ul>
                    </footer>
                </div>
    <?php
        }
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
        }
    }
    if ($address != $user['address']) {
        $sql = "UPDATE users SET address = :address
        WHERE id = :userid";
        $statement = $db->prepare($sql);

        $result = $statement->execute(array('address' => $address, 'userid' => $user['id']));
        if (!$result) {
            echo "Error update adrress<br>";
            $error = true;
        }
    }
    if ($housenumber != $user['housnumber']) {
        $sql = "UPDATE users SET housenumber = :housenumber
        WHERE id = :userid";
        $statement = $db->prepare($sql);

        $result = $statement->execute(array('housenumber' => $housenumber, 'userid' => $user['id']));
        if (!$result) {
            echo "Error update housenumber<br>";
            $error = true;
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

            $sql = "INSERT INTO orders (order_no,user_id,product_id,quantity) 
                    VALUES (:order_no,:user_id,:product_id,:quantity)";
            $statement = $db->prepare($sql);

            foreach ($found as $orders) {         // Order all items in cart
                $result = $statement->execute(array(
                    'order_no' => $orderNumber, 'user_id' => $orders['user_id'],
                    'product_id' => $orders['product_id'], 'quantity' => $orders['quantity']
                ));
            }


            if ($result) {          // Check for errors and get order number
                $statement = $db->prepare("SELECT * FROM orders WHERE user_id = :userid");
                $result = $statement->execute(array('email' => $email));
                $userId = $statement->fetch();
                $_SESSION['userId'] = $userId;      // Sets User Id
                echo "<label>$email</label></br>";
                echo "Registered sucessfully!<br>";
                $showCheckout = false;
                //header("Location: index.php");
            } else {
                echo 'Beim Abspeichern ist leider ein Fehler aufgetreten<br>';
            }
        }
    }
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