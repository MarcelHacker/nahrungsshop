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
    <title>Tables</title>
</head>

<body>
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
    <table class="table">
        <label>Cart</label>
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
            <?php

            $stmt = $mysql->prepare("SELECT * FROM cart");
            $stmt->execute();
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
        </tbody>
    </table>

    <table class="table"> //TODO table orders
        <label>Orders</label>
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
            <?php

            $stmt = $mysql->prepare("SELECT * FROM orders");
            $stmt->execute();
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
        </tbody>
    </table>

    <table class="table">
        <label>Contact</label>
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
            <?php

            $stmt = $mysql->prepare("SELECT * FROM contact");
            $stmt->execute();
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
        </tbody>
    </table>

    <table class="table">
        <label>Categories</label>
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Title</th>
                <th scope="col">Created</th>
                <th scope="col">Modified</th>
            </tr>
        </thead>
        <tbody>
            <?php

            $stmt = $mysql->prepare("SELECT * FROM categories");
            $stmt->execute();
            while ($row = $stmt->fetch()) {
            ?>
                <tr>
                    <th scope="row"><?php echo $row["id"] ?></th>
                    <td><?php echo $row["title"] ?></td>
                    <td><?php echo $row["created"] ?></td>
                    <td><?php echo $row["modified"] ?></td>
                </tr>
            <?php
            }
            ?>
        </tbody>
</body>

</html>