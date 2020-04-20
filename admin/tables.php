<?php

/**
 * A summary informing the user what the associated element does.
 *
 * A *description*, that can span multiple lines, to go _in-depth_ into the details of this element
 * and to provide some background information or textual references.
 *
 *
 * 
 */
session_start();        // For session variable
include_once("../function/database.php");    // For functions

if (!isloggedin()) {                    //User not logged in?
    header("Location: ../admin.php");    // Go to admin login
    exit;                           // Prevents loading this page
} else if ($_SESSION['userId'] != 1) { // Is the user an admin?
    header("Location: ../admin.php");
    exit;
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
    <title>Brain Food - Tables</title>
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
                <a class="nav-link" href="products.php">Products</a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" href="tables.php">Tables</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="../logout.php">Logout</a>
            </li>
        </ul>
    </nav>

    <table class="table">
        <h3>Cart</h3>
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">User_id</th>
                <th scope="col">Product_id</th>
                <th scope="col">Quantity</th>
                <th scope="col">Created</th>
            </tr>
        </thead>
        <tbody>
            <div class="border border-primary">
                <?php
                $db = getDB();
                if (!$db) {
                    die();
                } else {
                    $sql = "SELECT * FROM cart ORDER by id ASC";
                    $stmt = $db->prepare($sql);
                    $result = $stmt->execute();

                    while ($row = $stmt->fetch()) {
                ?>
                        <tr>
                            <th scope="row"><?php echo $row["id"] ?></th>
                            <td><?php echo $row["user_id"] ?></td>
                            <td><?php echo $row["product_id"] ?></td>
                            <td><?php echo $row["quantity"] ?></td>
                            <td><?php echo $row["created"] ?></td>
                        </tr>
                    <?php
                    }
                    ?>
            </div>
        </tbody>
    </table>

    <table class="table">
        <h3>Orders</h3>
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Oder_no</th>
                <th scope="col">User_id</th>
                <th scope="col">Product_id</th>
                <th scope="col">Quantity</th>
                <th scope="col">Created</th>
            </tr>
        </thead>
        <tbody>
            <div class="border border-secondary">
                <?php
                    $sql = "SELECT * FROM orders ORDER by id ASC";
                    $stmt = $db->prepare($sql);
                    $result = $stmt->execute();

                    while ($row = $stmt->fetch()) {
                ?>
                    <tr>
                        <th scope="row"><?php echo $row["id"] ?></th>
                        <td><?php echo $row["order_no"] ?></td>
                        <td><?php echo $row["user_id"] ?></td>
                        <td><?php echo $row["product_id"] ?></td>
                        <td><?php echo $row["quantity"] ?></td>
                        <td><?php echo $row["created"] ?></td>
                    </tr>
                <?php
                    }
                ?>
            </div>
        </tbody>
    </table>

    <table class="table">
        <h3>Contact</h3>
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Email</th>
                <th scope="col">Name</th>
                <th scope="col">Subject</th>
                <th scope="col">Message</th>
                <th scope="col">Created</th>
            </tr>
        </thead>
        <tbody>
            <div class="border border-success">
                <?php
                    $sql = "SELECT * FROM contact ORDER by id ASC";
                    $stmt = $db->prepare($sql);
                    $result = $stmt->execute();

                    while ($row = $stmt->fetch()) {
                ?>
                    <tr>
                        <th scope="row"><?php echo $row["id"] ?></th>
                        <td><?php echo $row["email"] ?></td>
                        <td><?php echo $row["name"] ?></td>
                        <td><?php echo $row["subject"] ?></td>
                        <td><?php echo $row["message"] ?></td>
                        <td><?php echo $row["created"] ?></td>
                    </tr>
                <?php
                    }
                ?>
            </div>
        </tbody>
    </table>

    <table class="table">
        <h3>Categories</h3>
        <thead>
            <tr>
                <th scope="col">Cat_ID</th>
                <th scope="col">Title</th>
                <th scope="col">Created</th>
            </tr>
        </thead>
        <tbody>
            <div class="border border-info">
                <?php

                    $sql = "SELECT * FROM categories";
                    $stmt = $db->prepare($sql);
                    $result = $stmt->execute();

                    while ($row = $stmt->fetch()) {
                ?>
                    <tr>
                        <th scope="row"><?php echo $row["cat_id"] ?></th>
                        <td><?php echo $row["title"] ?></td>
                        <td><?php echo $row["created"] ?></td>
                    </tr>
            <?php
                    }
                }
            ?>
            </div>
        </tbody>
</body>

</html>