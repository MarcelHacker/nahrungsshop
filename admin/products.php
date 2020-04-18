<?php
session_start();
define('DB_DATABASE', 'brainfooddb');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_HOST', '127.0.0.1');
define('DB_CHARSET', 'utf8');
/*if ($_SESSION['userId'] != 0) {
    header("Location: ../admin.php");
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
} ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
    <title>Brain Food - Products</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="description" content="foodshop" />
    <meta name="keywords" content="webshop" />
    <meta name="robots" content="index,follow" />
    <link rel="stylesheet" type="text/css" href="..\assets\css\bootstrap.min.css" />
    <link rel="stylesheet" type="text/css" href="..\assets\fontawesome\css\all.css" /> <!-- For icons -->
</head>

<body>
    <div>
        <h1><span class="badge badge-secondary-">Brain Food</span></h1>
    </div>
    <nav>
        <ul class="nav justify-content-center">
            <li class="nav-item">
                <a class="nav-link" href="index.php">Users</a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" href="products.php">Products</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="tables.php">Tables</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="../logout.php">Logout</a>
            </li>
        </ul>
    </nav>
    <nav>
        <div class="nav nav-tabs" id="nav-tab" role="tablist">
            <a class="nav-item nav-link active" id="all" name="submit" href="products.php" data-toggle="tab" role="tab" aria-controls="nav-home" aria-selected="true">All</a>
            <a class="nav-item nav-link" id="priceasc" name="submit" href="products.php?priceASC" data-toggle="tab" role="tab" aria-controls="nav-profile" aria-selected="false"></a>
            <a class="nav-item nav-link" id="categorieasc" name="submit" href="products.php?catASC" data-toggle="tab" role="tab" aria-controls="nav-contact" aria-selected="false"></a>
        </div>
    </nav>
    <div class="tab-content" id="nav-tabContent">
        <div class="tab-pane fade show active" href="products.php" id="all" role="tabpanel" aria-labelledby="nav-home-tab"></div>
        <div class="tab-pane fade show active" href="products.php?priceASC" id="priceasc" role="tabpanel" aria-labelledby="nav-profile-tab"></div>
        <div class="tab-pane fade show active" id="categorieasc" role="tabpanel" aria-labelledby="nav-contact-tab"></div>
    </div>
    <table class="table">
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Title</th>
                <th scope="col">Description</th>
                <th scope="col">Price</th>
                <th scope="col">Cat_id</th>
                <th scope="col">Created</th>
                <th scope="col">Modified</th>
                <th scope="col">Source</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $db = getDB();
            if (!$db) {
                die();
            } else {
                $sql = "SELECT * FROM products ORDER by id ASC";
                $stmt = $db->prepare($sql);
                $result = $stmt->execute();

                while ($row = $stmt->fetch()) {
            ?>
                    <tr>
                        <th scope="row"><?php echo $row["id"] ?></th>
                        <td><?php echo $row["title"] ?></td>
                        <td><?php echo $row["description"] ?></td>
                        <td><?php echo $row["price"] ?> €</td>
                        <td><?php echo $row["cat_id"] ?></td>
                        <td><?php echo $row["created"] ?></td>
                        <td><?php echo $row["modified"] ?></td>
                        <td><?php echo $row["source"] ?></td>
                        <td><a href="products/edit.php?id=<?php echo $row["id"] ?>"><i class="fas fa-edit"></i></a><a href="products/edit.php?del=<?php echo $row["id"] ?>"><i class="fas fa-user-minus"></i></a></td>
                    </tr>
            <?php
                }
            }
            ?>
        </tbody>
    </table>
</body>
<script src="..\assets\js\bootstrap.js"></script>
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

</html>