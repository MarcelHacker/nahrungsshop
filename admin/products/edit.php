<?php
session_start();
include_once("../../function/database.php");
include_once("../../function/product.php");
include_once("../../function/user.php");
include_once("../../function/cart.php");

if (isloggedin() == 0) {
    header("Location: ../../admin.php");
    exit;
} else if ($_SESSION['userId'] != 1) {
    header("Location: ../../admin.php");
    exit;
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
    <title>Brain Food - Products</title>
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
                <a class="nav-link" href="../index.php">Users</a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" href="../products.php">Products</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="../tables.php">Tables</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="../../logout.php">Logout</a>
            </li>
        </ul>
    </nav>
    <?php
    $db = getDB();
    if (!$db) {
        echo "Error database connection<br>";
        die();
    }

    if (isset($_GET["del"])) {
        if (!empty($_GET["del"])) {
            $productId = $_GET["del"];

            $sql = "DELETE FROM prdoucts WHERE id = :productid";
            $stmt = $db->prepare($sql);
            $result = $stmt->execute(array(":productid" => $productId));
            if ($result) {
                echo "<p>Product sucessfully deleted</p>";
            } else {
                echo "<p>Error product remove</p>";
            }
        }
    }

    if (isset($_GET["add"])) {
        $showProdFormular = true;
        if (isset($_POST['add'])) {
            $error = false;
            $title = $_POST["title"];
            $description = $_POST["description"];
            $price = $_POST["price"];
            $cat_id = $_POST["cat_id"];
            $source = $_POST["source"];

            // Validate Data
            if (!$title) {
                echo 'Please enter title<br>';
                $error = true;
            }
            if (!$description) {
                echo 'Enter description<br>';
                $error = true;
            }
            if (!$price) {
                echo 'Enter Price<br>';
                $error = true;
            }
            if (!$cat_id) {
                echo 'Enter product categorie<br>';
                $error = true;
            }
            if (!$source) {
                echo 'Enter picture path<br>';
                $error = true;
            }


            //Überprüfe, dass die E-Mail-Adresse noch nicht registriert wurde
            if (!$error) {
                $product = getProductWithTitle($title);
                if ($product) {
                    echo 'Product already exists<br>';
                    $error = true;
                }
            }

            //Keine Fehler, wir können den Nutzer registrieren
            if (!$error) {
                $sql = "INSERT INTO products (title,description,price,cat_id,created,source) 
                        VALUES (:title,:description,:price,:cat_id,CURRENT_TIMESTAMP(),:source)";
                $statement = $db->prepare($sql);

                $result = $statement->execute(array(
                    'title' => $title, 'description' => $description, 'price' => $price, 'cat_id' => $cat_id,
                    'source' => $source
                ));

                if ($result) {
                    $sql = "SELECT id FROM products WHERE title = :title";
                    $statement = $db->prepare($sql);
                    $statement->execute(array('title' => $title));
                    $productId = $statement->fetch();
                    if ($productId) {
                        echo "Product sucessfully created<br>";
                        $showProdFormular = false;
                    }
                } else {
                    echo 'Error product creating<br>';
                }
            }
        }
        if ($showProdFormular = true) {
    ?>
            <form action="edit.php?add" method="POST">
                <div class="form-group col-md-6">
                    <label for="title">Title</label>
                    <input type="text" class="form-control" name="title" id="title" placeholder="" require>
                </div>
                <div class="form-group col-md-6">
                    <label for="descr">Description</label>
                    <input type="text" class="form-control" name="description" id="description" placeholder="" require>
                </div>
                <div class="form-group col-md-6">
                    <label for="price">Price €</label>
                    <input type="number" class="form-control" name="price" id="price" placeholder="" require></input>
                </div>
                <div class="form-group col-md-6">
                    <label for="source">Source</label>
                    <input type="text" class="form-control" name="source" id="source" placeholder="" require>
                </div>
                <div class="container">
                    <label for="cat_id">Categorie</label>
                    <select class="custom-select" name="cat_id" id="cat_id" aria-label="Example select with button addon">
                        <?php
                        $sql = "SELECT *
                            FROM categories";

                        $result = $db->query($sql);
                        if (!$result) {
                            return [];
                        }
                        $categories = [];
                        while ($row = $result->fetch()) {
                            $categories[] = $row;
                        }
                        foreach ($categories as $categorie) :
                        ?>
                            <option value="<?= $categorie['cat_id'] ?>"><?= $categorie['title'] ?> </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="input-group-append p-2">
                    <button class="btn btn-outline-secondary" name="add" type="sumbit">Create</button>
                </div>
            </form>
            <?php
        }
    }

    if (isset($_GET["id"])) {
        $showProductForm = true;
        if (!empty($_GET["id"])) {
            $productId = $_GET["id"];
            if (isset($_POST["submit"])) {
                $title = $_POST["title"];
                $description = $_POST["description"];
                $price = $_POST["price"];
                $cat_id = $_POST["cat_id"];
                $source = $_POST["source"];
                echo $title;
                echo $description;
                echo $price;
                echo $cat_id;
                echo $source;

                $sql = "UPDATE products SET title = :title, description = :description, price = :price, cat_id = :cat_id, source = :source 
                WHERE id = :productid";
                $stmt = $db->prepare($sql);
                $result = $stmt->execute(array('title' => $title, 'description' => $description, 'price' => $price, 'cat_id' => $cat_id, 'source' => $source, 'productid' => $productId));

                if ($result) {
                    echo "<p>Product sucessfully updated</p>";
                    $showProductForm = false;
                } else {
                    echo "<p>Error Product edit</p>";
                }
            }

            $sql = "SELECT * FROM products WHERE id = :productid";

            $stmt = $db->prepare($sql);
            $stmt->execute(array(":productid" => $productId));
            $row = $stmt->fetch();

            if ($showProductForm == true) {
            ?>
                <form action="edit.php?id=<?php echo $_GET["id"] ?>" method="POST">
                    <div class="form-group col-md-6">
                        <label for="title">Title</label>
                        <input type="text" class="form-control" name="title" id="title" value="<?php echo $row["title"] ?>" placeholder="" require>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="descr">Description</label>
                        <input type="text" class="form-control" name="description" id="description" value="<?php echo $row["description"] ?>" placeholder="" require>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="price">Price €</label>
                        <input type="number" class="form-control" name="price" id="price" value="<?php echo $row["price"] ?>" placeholder="" require></input>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="source">Source</label>
                        <input type="text" class="form-control" name="source" id="source" value="<?php echo $row["source"] ?>" placeholder="" require>
                    </div>
                    <div class="container">
                        <label for="cat_id">Categorie</label>
                        <select class="custom-select" name="cat_id" id="cat_id" aria-label="Example select with button addon">
                            <?php
                            $sql = "SELECT *
                            FROM categories";

                            $result = $db->query($sql);
                            if (!$result) {
                                return [];
                            }
                            $categories = [];
                            while ($row = $result->fetch()) {
                                $categories[] = $row;
                            }
                            foreach ($categories as $categorie) :
                            ?>
                                <option value="<?= $categorie['cat_id'] ?>"><?= $categorie['title'] ?> </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="input-group-append p-2">
                        <button class="btn btn-outline-secondary" name="submit" type="sumbit">Save</button>
                    </div>
                </form>
            <?php
            }
        } else {
            //edit.php?id
            ?>
            <p>No product selected</p>
    <?php
        }
    }
    ?>
</body>

</html>