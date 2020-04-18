<?php
session_start();
define('DB_DATABASE', 'brainfooddb');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_HOST', '127.0.0.1');
define('DB_CHARSET', 'utf8');
/*if ($_SESSION['userId'] != 0) {
    header("Location: ../../admin.php");
    exit;
} */
function getDB()  // Database connection
{
    static $db;
    if ($db instanceof PDO) {
        return $db;
    }
    $dsn = sprintf("mysql:host=%s;dbname=%s;charset=%s", DB_HOST, DB_DATABASE, DB_CHARSET);
    $db = new PDO($dsn, DB_USERNAME, DB_PASSWORD);
    return $db;
}
function getUserWithEmail(string $email)
{
    $db = getDB();
    if (!$db) {
        die();
    } else {

        $statement = $db->prepare("SELECT * FROM users WHERE email = :email");
        $result = $statement->execute(array('email' => $email));
        $user = $statement->fetch();    // Alle User mit der Email
    }
    return $user;
} ?>

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
        if (isset($_GET["del"])) {
            if (!empty($_GET["del"])) {
                $stmt = $mysql->prepare("DELETE FROM users WHERE ID = :id");
                $stmt->execute(array(":id" => $_GET["del"]));

                echo "<p>User successfully deleted</p>";
            }
        }

        if (isset($_GET["add"])) {
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
                    $user = getUserWithEmail($email);

                    if ($user) {
                        echo 'Email address already used<br>';
                        $error = true;
                    }
                }

                //Keine Fehler, wir können den Nutzer registrieren
                if (!$error) {
                    $db = getDB();
                    if (!$db) {
                        echo "Error database connection<br>";
                        die();
                    } else {

                        $statement = $db->prepare("INSERT INTO users (firstname,lastname,email,address,housenumber,city,country,password,postcode,
            birthdate) VALUES (:firstname,:lastname,:email,:address,:housenumber,:city,:country,:password,:postcode,:birthdate)");

                        $hash = password_hash($password, PASSWORD_BCRYPT);  // Verschlüsselt das Password

                        $result = $statement->execute(array(
                            'firstname' => $firstname, 'lastname' => $lastname, 'email' => $email, 'address' => $address,
                            'housenumber' => $housenumber, 'city' => $city, 'country' => $country, 'password' => $hash, 'postcode' => $postcode, 'birthdate' => $birthdate
                        ));
                    }
                    if ($result) {
                        $statement = $db->prepare("SELECT id FROM users WHERE email = :email");
                        $result = $statement->execute(array('email' => $email));
                        $userId = $statement->fetch();
                        if ($userId) {
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
        if (isset($_GET["id"])) {
            $showUserForm = true;
            if (!empty($_GET["id"])) {
                $userid = $_GET['id'];
                $db = getDB();
                if (!$db) {
                    echo "Error database connection<br>";
                    die();
                } else {
                    if (isset($_POST["edit"])) {
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
                            $showUserForm = false;
                        } else {
                            echo "<p>User edit error</p>";
                        }
                    }

                    $stmt = $db->prepare("SELECT * FROM users WHERE id = :userid");
                    $stmt->execute(array(":userid" => $userid));
                    $row = $stmt->fetch();
                    if ($showUserForm = true) {
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
                <p>Kein Benutzer wurde angefragt</p>
        <?php
            }
        }
        ?>

    </body>
    <script src="assets/js/bootstrap.min.js"></script>

</html>