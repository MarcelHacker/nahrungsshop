<?php
session_start();
include_once("../template/header.php");
if ($_SESSION['userId'] != 0) {
    header("Location: ../admin.php");
    exit;
}
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Benutzer bearbeiten</title>
</head>

<body>
    <?php
    if (isset($_GET["del"])) {
        if (!empty($_GET["del"])) {
            $stmt = $mysql->prepare("DELETE FROM prdoucts WHERE ID = :id");
            $stmt->execute(array(":id" => $_GET["del"]));

            echo "<p>Der Benutzer wurde gelöscht</p>";
        }
    }

    if (isset($_GET["id"])) {
        if (!empty($_GET["id"])) {
            require("mysql.php");
            if (isset($_POST["submit"])) {
                $stmt = $mysql->prepare("UPDATE products SET USERNAME = :user, EMAIL = :email WHERE ID = :id");
                $stmt->execute(array(":user" => $_POST["username"], ":email" => $_POST["email"], ":id" => $_GET["id"]));

                echo "<p>Der Benutzer wurde gespeichert.</p>";
            }
            $stmt = $mysql->prepare("SELECT * FROM products WHERE ID = :id");
            $stmt->execute(array(":id" => $_GET["id"]));
            $row = $stmt->fetch();
    ?>
            <form action="edit.php?id=<?php echo $_GET["id"] ?>" method="post">
                <input type="text" name="title" value="<?php echo $row["title"] ?>" placeholder="Tomatoes" require><br>
                <input type="text" name="description" value="<?php echo $row["description"] ?>" placeholder="X g Fresh Tomatoes" require><br>
                <input type="numbers" name="price" value="<?php echo $row["price"] ?>" placeholder="3" require><br>
                <input type="numbers" name="cat_id" value="<?php echo $row["cat_id"] ?>" placeholder="Categorie" require><br>
                <input type="text" name="source" value="<?php echo $row["source"] ?>" placeholder="picture path" require><br>
                <button name="submit" type="submit">Save</button>
            </form>
        <?php
        } else {
            //edit.php?id
        ?>
            <p>Kein Product wurde angefragt</p>
        <?php
        }
    } else {
        //edit.php
        ?>
        <p>Kein Product wurde angefragt</p>
    <?php
    }
    ?>
</body>

</html>