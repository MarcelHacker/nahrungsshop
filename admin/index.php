<?php
session_start();
include_once("../../template/header.php");
/*if (isloggedin() != 0) {
    header("Location: ../admin.php");
    exit;
} */
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
    <title>Brain Food - Users</title>
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
    </nav>
    <nav>
        <div class="nav nav-tabs" id="nav-tab" role="tablist">
            <a class="nav-item nav-link active" id="all" name="submit" href="products.php" data-toggle="tab" role="tab" aria-controls="nav-home" aria-selected="true">All</a>
            <div class="container col-1 ">
                <a class="btn btn-success" href="users/edit.php?add" role="button">Add</a>
            </div>
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
                <th scope="col">Firstname</th>
                <th scope="col">Lastname</th>
                <th scope="col">Email</th>
                <th scope="col">City</th>
                <th scope="col">Postcode</th>
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
            $db = getDB();
            if (!$db) {
                die();
            } else {
                $sql = "SELECT * FROM users ORDER by id ASC";
                $stmt = $db->prepare($sql);
                $result = $stmt->execute();

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
                        <td>
                            <a href="users/edit.php?id=<?php echo $row["id"] ?>"><i class="fas fa-edit"></i></a>
                            <a href="users/edit.php?del=<?php echo $row["id"] ?>"><i class="fas fa-user-minus"></i></a>
                        </td>
                    </tr>
            <?php
                }
            }
            ?>
        </tbody>
    </table>

</body>

</html>