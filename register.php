<?php
include_once("template/header.php");

$cookie_name = "userId";      // user id
if (!isset($_COOKIE[$cookie_name])) //wenn nicht eingeloggt User.php nicht anzeigen
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
        <form class="form-inline my-2 my-lg-0" action="search.php" method="GET">
            <input class="form-control mr-sm-1" type="search" placeholder="Search" aria-label="Search">
            <button class="btn btn-outline-success my-2 my-sm-0" type="submit" name="search" id="search">Search</button>
        </form>
        </div>
    </nav>
    <?php
} else {
    $db = getDB();
    if (!$db) {
        die("Error");
    } else {
        $res = mysqli_query($db, "select id from user where id='$cookie_name';");
        $userid = mysqli_fetch_array($res, MYSQLI_ASSOC);
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
            <form class="form-inline my-2 my-lg-0" action="search.php" method="GET">
                <input class="form-control mr-sm-1" type="search" placeholder="Search" aria-label="Search">
                <button class="btn btn-outline-success my-2 my-sm-0" type="submit" name="search" id="search">Search</button>
            </form>
            </div>
        </nav>
        <!--cart insert-->

<?php
    }
    echo "You are already logged in";
    sleep(1.5);    //1,5 warten
    header("Location: index.php");
}
$showFormular = true;

if (isset($_POST['register'])) {
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
        echo 'Bitte eine gültige E-Mail-Adresse eingeben<br>';
        $error = true;
    }
    if (!$firstname) {
        echo 'Wrong firstname<br>';
        $error = true;
    }
    if (!$lastname) {
        echo 'Wrong lastname<br>';
        $error = true;
    }
    if (strlen($password) == 0) {
        echo 'Bitte ein Passwort angeben<br>';
        $error = true;
    }
    if ($password != $confirmpassword) {
        echo 'Die Passwörter müssen übereinstimmen<br>';
        $error = true;
    }
    if (!$birthdate) {
        echo 'Birthdate is false<br>';
        $error = true;
    }
    if (!$address) {
        echo 'adress is false<br>';
        $error = true;
    }
    if (!$city) {
        echo 'City is false<br>';
        $error = true;
    }
    if (!$country) {
        echo 'Choose country<br>';
        $error = true;
    }
    if (!$postcode) {
        echo 'Wrong post code<br>';
        $error = true;
    }

    //Überprüfe, dass die E-Mail-Adresse noch nicht registriert wurde
    if (!$error) {
        $db = getDB();
        if (!$db) {
            echo "Error database connection";
            die();
        } else {
            $statement = $db->prepare("SELECT * FROM users WHERE email = :email");
            $result = $statement->execute(array('email' => $email));
            $email = $statement->fetch();   // Email schon vorhanden?

            if ($email !== false) {
                echo 'Diese E-Mail-Adresse ist bereits vergeben<br>';
                $error = true;
            }
        }
    }

    //Keine Fehler, wir können den Nutzer registrieren
    if (!$error) {
        //$passwort_hash = password_hash($password, PASSWORD_DEFAULT);
        $db = getDB();
        if (!$db) {
            echo "Error database connection";
            die();
        } else {

            $statement = $db->prepare("INSERT INTO users (firstname,lastname,email,address,housenumber,city,country,password,postcode,
            birthdate) VALUES (:firstname, :lastname, :email, :address, :housenumber, :city, :country, :password, :postcode, :birthdate)");

            $hash = password_hash($password, PASSWORD_BCRYPT);  // Verschlüsselt das Password

            $result = $statement->execute(array(
                'firstname' => $firstname, 'lastname' => $lastname, 'email' => $email, 'address' => $address,
                'housenumber' => $housenumber, 'city' => $city, 'country' => $country, 'password' => $hash, 'postcode' => $postcode, 'birthdate' => $birthdate

            ));


            if ($result) {
                $statement = $db->prepare("SELECT id FROM users WHERE email = '$email'");
                $result = $statement->execute(array('email' => $email));
                $userId = $statement->fetch();
                echo 'Du wurdest erfolgreich registriert';
                $showFormular = false;
                //setcookie("userId", $userId);
                sleep(1, 5);    //1,5 warten
                header("Location: index.php");
            } else {
                echo 'Beim Abspeichern ist leider ein Fehler aufgetreten<br>';
            }
        }
    }
}
if ($showFormular == true) {
    include_once("template/registerForm.php");
}
include_once("template/footer.php");
?>
<script src="assets/js/bootstrap.min.js"></script>
</body>

</html>