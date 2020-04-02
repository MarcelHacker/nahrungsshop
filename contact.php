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
                <a class="nav-link active" href="about.php">About</a>
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
                    <a class="nav-link active" href="contact.php">About</a>
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
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    Cart ()
                </li>
            </ul>
        </nav>
<?php
        //<?= $cartItems 
    }
}

if (isset($_POST['contact'])) {
    $email = $_POST['email'];
    $name = $_POST['name'];
    $subj = $_POST['subject'];
    $mesg = $_POST['message'];

    $db = getDB();
    if (!$db) {
        echo "Error database connection";
        die();
    } else {
        $sql = "insert into contact (email,name,subject,message) values('$email','$name','$subj','$mesg')";
        $statement = $db->prepare($sql);
        $result = $statement->execute(array('email' => $email, 'name' => $name, 'subject' => $subj, 'message' => $mesg));

        if (!$result == false) {
            echo "<font>Message sent successfully</font>";
        } else {
            echo "<font>Error contact message</font>";
        }
    }
}
include_once("template/aboutCard.php");
?>
<div class="">
    <?= include_once("template/footer.php"); ?>
</div>
<script src="assets/js/bootstrap.min.js"></script>
</body>

</html>