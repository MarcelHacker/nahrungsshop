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
    <table class="table">
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Firstname</th>
                <th scope="col">Lastname</th>
                <th scope="col">Email</th>
                <th scope="col">City</th>
                <th scope="col">Post Code</th>
                <th scope="col">Address</th>
                <th scope="col">Country</th>
                <th scope="col">Housenumber</th>
                <th scope="col">Birthdate</th>
                <th scope="col">Created</th>
                <th scope="col">Modified</th>
            </tr>
        </thead>
        <tbody>
            <?php

            $stmt = $mysql->prepare("SELECT * FROM users");
            $stmt->execute();
            while ($row = $stmt->fetch()) {
            ?>
                <tr>
                    <th scope="row"><?php echo $row["id"] ?></th>
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
        </tbody>
    </table>
</body>

</html>