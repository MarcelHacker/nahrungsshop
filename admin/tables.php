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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/js/all.min.js"></script>
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
    <table>
        <label>Cart</label>
        <tr>
            <th>ID</th>
            <th>User_id</th>
            <th>Product_id</th>
            <th>Quantity</th>
            <th>Created</th>
        </tr>

        <?php

        $stmt = $mysql->prepare("SELECT * FROM cart");
        $stmt->execute();
        while ($row = $stmt->fetch()) {
        ?>
            <tr>
                <td><?php echo $row["id"] ?></td>
                <td><?php echo $row["user_id"] ?></td>
                <td><?php echo $row["product_id"] ?></td>
                <td><?php echo $row["quantity"] ?></td>
                <td><?php echo $row["created"] ?></td>
            </tr>
        <?php
        }
        ?>
    </table>

    <table>
        <label>Orders</label> //TODO table orders
        <tr>
            <th>ID</th>
            <th>User_id</th>
            <th>Product_id</th>
            <th>Quantity</th>
            <th>Created</th>
        </tr>

        <?php

        $stmt = $mysql->prepare("SELECT * FROM cart");
        $stmt->execute();
        while ($row = $stmt->fetch()) {
        ?>
            <tr>
                <td><?php echo $row["id"] ?></td>
                <td><?php echo $row["user_id"] ?></td>
                <td><?php echo $row["product_id"] ?></td>
                <td><?php echo $row["quantity"] ?></td>
                <td><?php echo $row["created"] ?></td>
            </tr>
        <?php
        }
        ?>
    </table>

    <table>
        <label>Contact</label>
        <tr>
            <th>ID</th>
            <th>Email</th>
            <th>Name</th>
            <th>Subject</th>
            <th>Message</th>
            <th>Created</th>
        </tr>

        <?php

        $stmt = $mysql->prepare("SELECT * FROM contact");
        $stmt->execute();
        while ($row = $stmt->fetch()) {
        ?>
            <tr>
                <td><?php echo $row["id"] ?></td>
                <td><?php echo $row["email"] ?></td>
                <td><?php echo $row["name"] ?></td>
                <td><?php echo $row["subject"] ?></td>
                <td><?php echo $row["message"] ?></td>
                <td><?php echo $row["created"] ?></td>
            </tr>
        <?php
        }
        ?>
    </table>

    <table>
        <label>Categories</label>
        <tr>
            <th>ID</th>
            <th>Title</th>
            <th>Created</th>
            <th>Modified</th>
        </tr>

        <?php

        $stmt = $mysql->prepare("SELECT * FROM categories");
        $stmt->execute();
        while ($row = $stmt->fetch()) {
        ?>
            <tr>
                <td><?php echo $row["id"] ?></td>
                <td><?php echo $row["title"] ?></td>
                <td><?php echo $row["created"] ?></td>
                <td><?php echo $row["modified"] ?></td>
            </tr>
        <?php
        }
        ?>
    </table>