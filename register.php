<?php

/**
 * Php file for the registration of a user
 * 
 * Used for the sign up website
 * 
 */
session_start();        // For session variable
include_once("./template/header.php");    // For functions

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
                <a class="btn mr-sm-4 btn-outline-dark" href="login.php">Sign In</a>
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
    $userId = (int) $_SESSION['userId'];  // Gets user id from session variable
    $user = getCurrentUser($userId);    // int because function expects
    if (!$user) {                   // No user with this id?
        echo "Error User id <br>";
        die();
    } else {
        $countCartItems = countProductsInCart($userId);
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
                    <a class="btn mr-sm-4 btn-outline-dark" href="logout.php">Logout</a>
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
}

$showFormular = true;

if (isset($_POST['register'])) {    // Registration for a new user
    $error = false;
    $firstname = $_POST["firstname"];
    $lastname = $_POST["lastname"];
    $email = $_POST["email"];
    $address = $_POST["address"];
    $housenumber = $_POST["housenumber"];
    $city = $_POST["city"];
    $country = $_POST["country"];
    $password = $_POST["password"];
    $confirmpassword = $_POST["confirmpassword"];
    $postcode = $_POST["postcode"];
    $birthdate = $_POST["birthdate"];

    // Validate Data
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo 'Please enter a correct email address<br>';
        $error = true;
    }
    if (!$firstname) {
        echo 'Type in an firstname<br>';
        $error = true;
    }
    if (!$lastname) {
        echo 'Type in an lastname<br>';
        $error = true;
    }
    if (strlen($email) == 0) {
        echo "Type in an email address<br>";
        $error = true;
    }
    if (strlen($password) == 0) {
        echo 'Type in a password<br>';
        $error = true;
    }
    if ($password != $confirmpassword) {
        echo 'Passwords do not match<br>';
        $error = true;
    }
    if (!$birthdate) {
        echo 'Type in your birthdate<br>';
        $error = true;
    }
    if (!$address) {
        echo 'Type in an address<br>';
        $error = true;
    }
    if (!$city) {
        echo 'Type in a city<br>';
        $error = true;
    }
    if (!$country) {
        echo 'Choose your country<br>';
        $error = true;
    }
    if (!$postcode) {
        echo 'Type in your zip<br>';
        $error = true;
    }

    //Check, if email is already registered
    if (!$error) {
        $user = getUserWithEmail($email);
        if ($user) {
            echo 'Email address already registered<br>';
            $error = true;
        }
    }

    // No error, we can register user
    if (!$error) {
        $db = getDB();  // Get database connection
        if (!$db) {
            echo "Error database connection<br>";
            die();
        } else {
            $sql = "INSERT INTO users (firstname,lastname,email,address,housenumber,city,country,password,postcode,
            birthdate, created) VALUES (:firstname,:lastname,:email,:address,:housenumber,:city,:country,:password,:postcode,:birthdate, :created)";
            $statement = $db->prepare($sql);

            $hash = password_hash($password, PASSWORD_BCRYPT);  // Verschlüsselt das Password

            $result = $statement->execute(array(
                'firstname' => $firstname, 'lastname' => $lastname, 'email' => $email, 'address' => $address,
                'housenumber' => $housenumber, 'city' => $city, 'country' => $country, 'password' => $hash, 'postcode' => $postcode, 'birthdate' => $birthdate, 'created' => getdate()
            ));


            if ($result) {  // User successfully registered
                $statement = $db->prepare("SELECT id FROM users WHERE email = :email");
                $statement->execute(array('email' => $email));
                $userId = $statement->fetch();
                $_SESSION['userId'] = $userId;   // Sets User Id
                $showFormular = false;
                sleep(0.5);                    // waits 0,5 seconds 
                header("Location: index.php");  // Go to index
                exit;                           // Prevents loading old page
            } else {    // No success
                echo 'Something went wrong<br>';
            }
        }
    }
}
if ($showFormular == true) {   // Prevents apearing, despite just registered
    include_once("./template/registerForm.php");
}
include_once("./template/footer.php");
?>
<script src="assets/js/bootstrap.min.js"></script>
</body>

</html>