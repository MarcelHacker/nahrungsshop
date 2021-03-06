<?php

/**
 * Php file for adding, editing and deleting a user
 *
 * Used in the admin config
 * 
 */
session_start();        // For session variable
include_once("../../function/database.php");    // For functions
include_once("../../function/user.php");

if (!isloggedin()) {                    //User not logged in?
    header("Location: ../../admin.php");    // Go to admin login
    exit;                           // Prevents loading this page
} else if ($_SESSION['userId'] != 1) { // Is the user an admin?
    header("Location: ../../admin.php");
    exit;
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
    <title>Brain Food - Users</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="description" content="foodshop" />
    <meta name="keywords" content="webshop" />
    <meta name="robots" content="index,follow" />
    <link rel="stylesheet" type="text/css" href="..\..\assets\css\bootstrap.min.css" />
    <link rel="stylesheet" type="text/css" href="..\..\assets\fontawesome\css\all.css" /> <!-- For icons -->
</head>

<body>
    <div>
        <h1><span class="badge badge-secondary-">Brain Food</span></h1>
    </div>
    <nav>
        <ul class="nav justify-content-center">
            <li class="nav-item">
                <a class="nav-link active" href="../index.php">Users</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="../products.php">Products</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="../tables.php">Tables</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="../../logout.php">Logout</a>
            </li>
        </ul>
    </nav>

    <body>
        <?php
        if (isset($_GET["del"])) {  // delete a user
            if (!empty($_GET["del"])) {
                $userId = $_GET["del"];

                $db = getDB();  // database connection
                if (!$db) {
                    echo "Error database connection<br>";
                    die();
                } else {
                    $sql = "DELETE FROM users WHERE id = :userid";
                    $statement = $db->prepare($sql);
                    $result = $statement->execute(array('userid' => $userId));
                    if ($result) {
                        echo "<p>User successfully deleted</p>";
                    } else {
                        echo "<p>Error remove user</p>";
                    }
                }
            }
        }

        if (isset($_GET["add"])) {  // create new user
            $showFormular = true;
            if (isset($_POST['add'])) {
                $error = false;
                $firstname = $_POST["firstname"];
                $lastname = $_POST["lastname"];
                $email = $_POST["email"];
                $address = $_POST["address"];
                $housenumber = $_POST["housenumber"];
                $city = $_POST["city"];
                $country = $_POST["country"];
                $password = $_POST["password"];
                $postcode = $_POST["postcode"];
                $birthdate = $_POST["birthdate"];

                // Validate Data
                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    echo 'Please enter correct Email address<br>';
                    $error = true;
                }
                if (!$firstname) {
                    echo 'Enter firstname<br>';
                    $error = true;
                }
                if (!$lastname) {
                    echo 'Enter lastname<br>';
                    $error = true;
                }
                if (strlen($email) == 0) {
                    echo "Enter Email<br>";
                    $error = true;
                }
                if (strlen($password) == 0) {
                    echo 'Enter Password<br>';
                    $error = true;
                }
                if (!$birthdate) {
                    echo 'Enter Birthdate<br>';
                    $error = true;
                }
                if (!$address) {
                    echo 'Enter address<br>';
                    $error = true;
                }
                if (!$city) {
                    echo 'Enter city<br>';
                    $error = true;
                }
                if (!$country) {
                    echo 'Choose country<br>';
                    $error = true;
                }
                if (!$postcode) {
                    echo 'Enter postcode<br>';
                    $error = true;
                }

                //Überprüfe, dass die E-Mail-Adresse noch nicht registriert wurde
                if (!$error) {
                    $user = getUserWithEmail($email); // returns user array

                    if ($user) {    // user with same email?
                        echo 'Email address already used<br>';
                        $error = true;
                    }
                }

                //Keine Fehler, wir können den Nutzer registrieren
                if (!$error) {
                    $db = getDB();  // database connection
                    if (!$db) {
                        echo "Error database connection<br>";
                        die();
                    } else {

                        $statement = $db->prepare("INSERT INTO users (firstname,lastname,email,address,housenumber,city,country,password,postcode,
            birthdate) VALUES (:firstname,:lastname,:email,:address,:housenumber,:city,:country,:password,:postcode,:birthdate)");

                        $hash = password_hash($password, PASSWORD_BCRYPT);  // encrypt password 

                        $result = $statement->execute(array(
                            'firstname' => $firstname, 'lastname' => $lastname, 'email' => $email, 'address' => $address,
                            'housenumber' => $housenumber, 'city' => $city, 'country' => $country, 'password' => $hash, 'postcode' => $postcode, 'birthdate' => $birthdate
                        ));
                    }
                    if ($result) {
                        $statement = $db->prepare("SELECT id FROM users WHERE email = :email");
                        $result = $statement->execute(array('email' => $email));
                        $userId = $statement->fetch();
                        if ($userId) {  // User created?
                            echo "User created sucessfully!<br>";
                            $showFormular = false;
                        }
                    } else {
                        echo 'Beim Abspeichern ist leider ein Fehler aufgetreten<br>';
                    }
                }
            }
            if ($showFormular = true) {
        ?>
                <form action="edit.php?add" method="POST">
                    <div class="form-group col-md-6">
                        <label for="inputFisrtname4">Firstname</label>
                        <input type="text" class="form-control" name="firstname" id="firstname" placeholder="Max" require>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="lastname">Lastname</label>
                        <input type="text" class="form-control" name="lastname" id="lastname" placeholder="Mustermann" require>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" name="email" id="email" placeholder="Email" require>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" name="password" id="password" placeholder="Password" require>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="birthdate">Birthdate</label>
                        <input type="date" class="form-control" name="birthdate" id="birthdate" placeholder="" require>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="inputAddress2">Address</label>
                        <input type="text" class="form-control" name="address" id="address" placeholder="Hufeisengasse" require>
                    </div>
                    <div class="form-group col-md-1">
                        <label for="houseNumber">Housenumber</label>
                        <input type="number" class="form-control" name="housenumber" id="housenumber" placeholder="1" require>
                    </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="city">City</label>
                            <input type="text" class="form-control" name="city" id="city" placeholder="Guntersdorf" require>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="country">State</label>
                            <select name="country" id="country" class="form-control" require>
                                <option selected>Choose...</option>
                                <option value="austria">Austria</option>
                                <option value="united kingdom">United Kingdom</option>
                                <option value="china">China</option>
                            </select>
                        </div>
                        <div class="form-group col-md-2">
                            <label for="postCode">Zip</label>
                            <input type="number" class="form-control" name="postcode" id="postcode" placeholder="1234" require>
                        </div>
                    </div>
                    <button name="add" type="submit">Create</button>
                </form>
                <?php
            }
        }
        if (isset($_GET["id"])) {   // edit user with user id
            $showUserForm = true;
            if (!empty($_GET["id"])) {
                $userid = $_GET['id'];
                $db = getDB();      // database connection
                if (!$db) {
                    echo "Error database connection<br>";
                    die();
                } else {
                    if (isset($_POST["edit"])) {    // edit formular submit
                        $firstname = $_POST["firstname"];
                        $lastname = $_POST["lastname"];
                        $email = $_POST["email"];
                        $address = $_POST["address"];
                        $housenumber = $_POST["housenumber"];
                        $city = $_POST["city"];
                        $country = $_POST["country"];
                        $password = $_POST["password"];
                        $postcode = $_POST["postcode"];
                        $birthdate = $_POST["birthdate"];

                        $sql = "UPDATE users SET firstname = :firstname,lastname = :lastname,email = :email,address = :address,housenumber = :housenumber,city = :city,country = :country,password = :password,postcode = :postcode,
                                birthdate = :birthdate
                                WHERE id = :userid";
                        $statement = $db->prepare($sql);

                        $hash = password_hash($password, PASSWORD_BCRYPT);  // Verschlüsselt das Password

                        $result = $statement->execute(array(
                            'firstname' => $firstname, 'lastname' => $lastname, 'email' => $email, 'address' => $address,
                            'housenumber' => $housenumber, 'city' => $city, 'country' => $country, 'password' => $hash, 'postcode' => $postcode, 'birthdate' => $birthdate, 'userid' => $userid
                        ));

                        if ($result) {
                            echo "<p>User successfully updated</p>";
                            $showUserForm = false;  // Hides user formular
                        } else {
                            echo "<p>User edit error</p>";
                        }
                    }

                    $stmt = $db->prepare("SELECT * FROM users WHERE id = :userid");
                    $stmt->execute(array(":userid" => $userid));
                    $row = $stmt->fetch();
                    if ($showUserForm == true) {
                ?>
                        <form action="edit.php?id=<?php echo $_GET["id"] ?>" method="POST">
                            <div class="form-group col-md-6">
                                <label for="inputFisrtname4">Firstname</label>
                                <input type="text" class="form-control" name="firstname" id="firstname" value="<?php echo $row["firstname"] ?>" placeholder="" require>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="lastname">Lastname</label>
                                <input type="text" class="form-control" name="lastname" id="lastname" value="<?php echo $row["lastname"] ?>" placeholder="" require>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" name="email" id="email" value="<?php echo $row["email"] ?>" placeholder="" require>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="password">Password</label>
                                <input type="password" class="form-control" name="password" id="password" value="<?php echo $row["password"] ?>" placeholder="" require>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="birthdate">Birthdate</label>
                                <input type="date" class="form-control" name="birthdate" id="birthdate" value="<?php echo $row["birthdate"] ?>" placeholder="" require>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="inputAddress2">Address</label>
                                <input type="text" class="form-control" name="address" id="address" value="<?php echo $row["address"] ?>" placeholder="" require>
                            </div>
                            <div class="form-group col-md-1">
                                <label for="houseNumber">Housenumber</label>
                                <input type="number" class="form-control" name="housenumber" id="housenumber" value="<?php echo $row["housenumber"] ?>" placeholder="" require>
                            </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="city">City</label>
                                    <input type="text" class="form-control" name="city" id="city" value="<?php echo $row["city"] ?>" placeholder="" require>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="country">State</label>
                                    <select name="country" id="country" class="form-control" require>
                                        <option selected value="<?php echo $row["country"] ?>"><?php echo $row["country"] ?></option>
                                        <option value="austria">Austria</option>
                                        <option value="united kingdom">United Kingdom</option>
                                        <option value="china">China</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="postCode">Zip</label>
                                    <input type="number" class="form-control" name="postcode" id="postcode" value="<?php echo $row["postcode"] ?>" placeholder="" require>
                                </div>
                            </div>
                            <button name="edit" type="submit">Save</button>
                        </form>
                <?php
                    }
                }
            } else {
                //edit.php?id
                ?>
                <p>No user asked</p>
        <?php
            }
        }
        ?>

    </body>
    <script src="assets/js/bootstrap.min.js"></script>

</html>