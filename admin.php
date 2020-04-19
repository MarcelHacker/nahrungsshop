<?php
session_start();
include_once("./template/header.php");

if (isLoggedIn()) {
    if ($_SESSION['userId'] == 1) {
        header("Location: admin/index.php");
        exit;
    }
}
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

if (isset($_POST['admin'])) {
    $error = false;
    $email = $_POST['email'];
    $password = $_POST['password'];
    $user = getUserWithEmail($email);

    $hash = password_hash($password, PASSWORD_BCRYPT);  // Verschlüsselt das Passoword

    if (!$user) {
        echo "<p color='red'>No user registered</p><br>";
        $error = true;
    }

    if (strlen($password) == 0) {
        echo "<p color='red'>Type in an password</p><br>";
        $error = true;
    }

    if (!$hash == $user['password']) {
        echo "<p color='red'>Wrong password</p><br>";
        $error = true;
    }

    echo "User Id = " . $user['id'] . "<br>";

    //Überprüfung des Passworts
    if (!$error) {
        if ($user['id'] == 1) {
            $_SESSION['userId'] = $user['id'];
            header("location: admin/index.php");
        } else {
            echo "<p color='red'>You are not an admin</p><br>";
        }
    } else {
        echo "<p color='red'>Email or Password is wrong</p><br>";
    }
}
?>
<div class="container">
    <div><br>
        <h1>
            ADMINISTRATOR LOGIN<br>
        </h1>
    </div>
    <fieldset>
        <br>
        <table>
            <form method="post" action="admin.php">
                <tr>
                    <td>Email:</td>
                    <td><label>
                            <input name="email" type="text" id="username">
                        </label></td>
                </tr>
                <tr>
                    <td>Password:</td>
                    <td><input name="password" type="password" id="password"></td>
                </tr>

                <tr>
                    <td colspan="1"><label>
                            <input name="admin" type="submit" id="submit" value="Login">
                        </label></td>
            </form>
        </table>
    </fieldset>
    <script src="assets/js/bootstrap.min.js"></script>
    </body>

    </html>