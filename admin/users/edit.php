<?php
session_start();
include_once("../template/header.php");
if ($_SESSION['userId'] != 0) {
    header("Location: ../admin.php");
    exit;
} ?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Benutzer bearbeiten</title>
</head>

<body>
    <?php
    if (isset($_GET["del"])) {
        if (!empty($_GET["del"])) {
            $stmt = $mysql->prepare("DELETE FROM users WHERE ID = :id");
            $stmt->execute(array(":id" => $_GET["del"]));

            echo "<p>Der Benutzer wurde gelöscht</p>";
        }
    }

    if (isset($_GET["id"])) {
        if (!empty($_GET["id"])) {
            require("mysql.php");
            if (isset($_POST["submit"])) {
                $stmt = $mysql->prepare("UPDATE users SET USERNAME = :user, EMAIL = :email WHERE ID = :id");
                $stmt->execute(array(":user" => $_POST["username"], ":email" => $_POST["email"], ":id" => $_GET["id"]));

                echo "<p>Der Benutzer wurde gespeichert.</p>";
            }
            $stmt = $mysql->prepare("SELECT * FROM users WHERE ID = :id");
            $stmt->execute(array(":id" => $_GET["id"]));
            $row = $stmt->fetch();
    ?>
            <form action="edit.php?id=<?php echo $_GET["id"] ?>" method="post">
                <input type="text" name="firstname" value="<?php echo $row["firstname"] ?>" placeholder="Firstname" require><br>
                <input type="text" name="lastname" value="<?php echo $row["lastname"] ?>" placeholder="Lastname" require><br>
                <input type="email" name="email" value="<?php echo $row["email"] ?>" placeholder="example@gmail.com" require><br>
                <input type="password" name="password" value="<?php echo $row["password"] ?>" placeholder="Password" require><br>
                <input type="text" name="city" value="<?php echo $row["city"] ?>" placeholder="City" require><br>
                <input type="numbers" name="postcode" value="<?php echo $row["postcode"] ?>" placeholder="Post Code" require><br>
                <input type="text" name="address" value="<?php echo $row["address"] ?>" placeholder="Address" require><br>
                <input type="numbers" name="housenumber" value="<?php echo $row["Housenumber"] ?>" placeholder="Housenumber" require><br>
                <input type="date" name="birthdate" value="<?php echo $row["birthdate"] ?>" placeholder="Birthdate" require><br>
                <input type="text" name="country" value="<?php echo $row["country"] ?>" placeholder="Country" require><br>
                <button name="submit" type="submit">Save</button>
            </form>
        <?php
        } else {
            //edit.php?id
        ?>
            <p>Kein Benutzer wurde angefragt</p>
        <?php
        }
    } else {
        //edit.php
        ?>
        <p>Kein Benutzer wurde angefragt</p>
    <?php
    }
    ?>
</body>

</html>