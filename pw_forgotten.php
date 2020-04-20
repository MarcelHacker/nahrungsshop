<?php
session_start();
include_once("./template/header.php");

if (isLoggedIn())   // User already logged in
{
    header("Location: index.php");
    die();
} else {
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
        <form class="form-inline my-2 my-lg-0" action="search.php" method="POST">
            <input class="form-control mr-sm-1" type="search" placeholder="Search" id="search_term" name="search_term" aria-label="Search">
            <button class="btn btn-outline-success my-2 my-sm-0" type="submit" name="search" id="search">Search</button>
        </form>
        </div>
    </nav>
<?php
}
$showForgottenPage = true;

if (isset($_POST['forgotten'])) {   // User loging in?
    $error = false;
    $email = $_POST['email'];
    $birthdate = $_POST['birthdate'];
    $password = $_POST['password'];
    $passwordConfirm = $_POST['passwordconfirm'];

    $user = getUserWithEmail($email);   // Check if Email already registered  

    if (!$user) {   // No user with this email?
        echo "<label>No user with this email registered</label><br>";
        $error = true;
    }

    if (strlen($password) == 0) { // Password typed in?
        echo "<label>Type in a password</label><br>";
        $error = true;
    }

    if (!$password == $passwordConfirm) { // Check is passoword matches
        echo "<label>Password do not match</label><br>";
        $error = true;
    }

    if (!$birthdate == $user['birthday']) { // Security check
        die();                              // No message 
        $error = true;
    }

    if (!$error) { // Now we can change user password
        $showForgottenPage = false;
        $user['id'] = $_SESSION['userId'];  // Sets user id in session variable

        $sql = "UPDATE users SET = password = :password
                WHERE id = :userid";
        $statement = $db->prepare($sql);

        $hash = password_hash($password, PASSWORD_BCRYPT);  // encrypt password

        $result = $statement->execute(array(
            'password' => $hash, 'userid' => $userid
        ));
        if (!$result) {
            echo "Error updating password<br>";
            die();
        } else {
            sleep(0.5);                    // waits 0,5 seconds
            header("Location: index.php"); // Got to home
            exit;                          // Prevents loading page
        }
    } else {
        echo "Excuse me, somthing went wrong<br>";
    }
}
if ($showForgottenPage == true) {
    include_once("./template/passwordForgotten.php");
}
?>
<div class="fixed-bottom">
    <?= include_once("template/footer.php"); ?>
</div>
<script src="assets/js/bootstrap.min.js"></script>
</body>

</html>