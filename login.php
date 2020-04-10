<?php
session_start();
include_once("template/header.php");

if (!isset($_SESSION['userId'])) //wenn nicht eingeloggt User.php nicht anzeigen
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
        <form class="form-inline my-2 my-lg-0" action="search.php" method="GET">
            <input class="form-control mr-sm-1" type="search" placeholder="Search" aria-label="Search">
            <button class="btn btn-outline-success my-2 my-sm-0" type="submit" name="search" id="search">Search</button>
        </form>
        </div>
    </nav>
    <?php
} else {
    if ($_SESSION['userId'] == "0" or $_SESSION['userId'] == "0") {
    ?>
        <div class="collapse navbar-collapse menubar">
            <ul class="nav navbar-nav navbar-right">
                <li><a href="admin_startseite.php">Startseite</a></li>
                <li><a href="admin_config.php">Produktkonfiguration</a></li>
                </li>
                <li><a href="login.php">Login</a></li>
                <li><a href="logout.php">Logout</a></li>
        </div>
        </div>
    <?php
    } else {
        $userId = $_SESSION['userId'];
        $user = getCurrentUser($userId);
        if (!$user) {
            echo "Error User Id";
        } else {
            echo "You are already logged in<br>";
            echo $user['id'];
        }
        //<?= $cartItems 

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
            <form class="form-inline my-2 my-lg-0" action="search.php" method="GET">
                <input class="form-control mr-sm-1" type="search" placeholder="Search" aria-label="Search">
                <button class="btn btn-outline-success my-2 my-sm-0" type="submit" name="search" id="search">Search</button>
            </form>
            </div>
        </nav>
        <?php
    }
}
include_once("template/loginForm.php");


if (isset($_POST['login'])) {
    $error = false;
    $email = $_POST['email'];
    $password = $_POST['password'];

    $user = getUserWithEmail($email);

        $hash = password_hash($password, PASSWORD_BCRYPT);  // Verschlüsselt das Passoword

        if (!$user) {
            echo "<label>Kein User mit der Email registriert </label><br>";
            $error = true;
        }

        if (strlen($password) == 0) {
            echo "<label>Pasword eingeben!</label><br>";
            $error = true;
        }

        if (!$hash == $user['password']) {
            echo "<label>Falsches Password! </label><br>";
            $error = true;
        }

        echo "User Id = " . $user['id'] . "<br>";

        //Überprüfung des Passworts
        if ($error == false) {
            $_SESSION['userId'] = $user['id'];
            echo "<label>Login erfolgreich! </label><br>";
        ?>
            <div class="modal" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Login</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <p>Sucessfully logged in!</p>
                        </div>
                        <div class="modal-footer">
                            <button href="login.php" type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button href="index.php" type="button" class="btn btn-primary">Home</button>
                        </div>
                    </div>
                </div>
            </div>
<?php
        } else {
            echo "E-Mail oder Passwort war ungültig<br>";
        }
    }
}
?>
<div class="fixed-bottom">
    <?= include_once("template/footer.php"); ?>
</div>
<script src="assets/js/bootstrap.min.js"></script>
</body>

</html>