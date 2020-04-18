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
    <title>Users</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/js/all.min.js"></script>
</head>

<body>
    <ul class="nav justify-content-center">
        <li class="nav-item">
            <a class="nav-link active" href="index.php">Users</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="products.php">Products</a>
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
            <th>Username</th>
            <th>Email</th>
            <th>erster Login</th>
            <th>letzter Login</th>
            <th>Aktionen</th>
        </tr>

        <?php

        $stmt = $mysql->prepare("SELECT * FROM users");
        $stmt->execute();
        while ($row = $stmt->fetch()) {
        ?>
            <tr>
                <td><?php echo $row["id"] ?></td>
                <td><?php echo $row["firstname"] ?></td>
                <td><?php echo $row["lastname"] ?></td>
                <td><?php echo $row["email"] ?></td>
                <td><?php echo $row["city"] ?></td>
                <td><?php echo $row["postcode"] ?></td>
                <td><?php echo $row["address"] ?></td>
                <td><?php echo $row["country"] ?></td>
                <td><?php echo $row["housenumber"] ?></td>
                <td><?php echo $row["birthdate"] ?></td>
                <td><?php echo $row["created"] ?></td>
                <td><?php echo $row["modified"] ?></td>
                <td><a href="users/edit.php?id=<?php echo $row["id"] ?>"><i class="fas fa-edit"></i></a><a href="users/edit.php?del=<?php echo $row["id"] ?>"><i class="fas fa-user-minus"></i></a></td>
            </tr>
        <?php
        }
        ?>
    </table>
</body>

</html>