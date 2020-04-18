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
function getProductWithTitle(string $title)
{
    $db = getDB();
    if (!$db) {
        die();
    } else {

        $statement = $db->prepare("SELECT * FROM products WHERE title = :title");
        $statement->execute(array('title' => $title));
        $product = $statement->fetch();
    }
    return $product;
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
                        VALUES (:title,:description,:price,:cat_id,:created,:source)";
                $statement = $db->prepare($sql);

                $result = $statement->execute(array(
                    'title' => $title, 'description' => $description, 'price' => $price, 'cat_id' => $cat_id,
                    'created' => CURRENT_TIMESTAMP(), 'source' => $source
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
    } else {
        //edit.php
        ?>
        <p>No product selected</p>
    <?php
    }
    ?>
</body>

</html>