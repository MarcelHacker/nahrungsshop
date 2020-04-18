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
    <title>Products</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/js/all.min.js"></script>
</head>

<body>
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
    <table>
        <tr>
            <th>ID</th>
            <th>Title</th>
            <th>Description</th>
            <th>Price</th>
            <th>Cat_id</th>
            <th>Created</th>
            <th>Modified</th>
            <th>Source</th>
        </tr>

        <?php

        $stmt = $mysql->prepare("SELECT * FROM products");
        $stmt->execute();
        while ($row = $stmt->fetch()) {
        ?>
            <tr>
                <td><?php echo $row["id"] ?></td>
                <td><?php echo $row["title"] ?></td>
                <td><?php echo $row["description"] ?></td>
                <td><?php echo $row["price"] ?></td>
                <td><?php echo $row["cat_id"] ?></td>
                <td><?php echo $row["created"] ?></td>
                <td><?php echo $row["modified"] ?></td>
                <td><?php echo $row["source"] ?></td>
                <td><a href="products/edit.php?id=<?php echo $row["id"] ?>"><i class="fas fa-edit"></i></a><a href="products/edit.php?del=<?php echo $row["id"] ?>"><i class="fas fa-user-minus"></i></a></td>
            </tr>
        <?php
        }
        ?>
    </table>
</body>

</html>