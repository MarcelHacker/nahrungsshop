<?php
session_start();
include_once("template/header.php");



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
    if ($error == false) {
        if ($user['id'] == 0) {
            $_SESSION['userId'] = $user['id'];
            header("location:admin/index.php");
        } else {
            echo "<p color='red'>You are not an admin</p><br>";
        }
    } else {
        echo "<p color='red'>E-Mail oder Passwort war ungültig</p><br>";
    }
}
?>
<html>

<div class="container">
    <div><br>
        <h1>
            ADMINISTRATOR LOGIN<br>
        </h1>
    </div>
    <fieldset>
        <br>
        <table>
            <form method="post" action="admin.php" name="admin">
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
                            <input name="submit" type="submit" id="submit" value="Login">
                        </label></td>
            </form>
        </table>
    </fieldset>
    <script src="assets/js/bootstrap.min.js"></script>
    </body>

</html>