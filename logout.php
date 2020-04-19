<?php
session_start();
session_unset();
session_destroy();
include_once("./template/header.php");
?>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <ul class="nav nav-tabs">
        <li class="nav-item">
            <a class="nav-link" href="index.php">Home</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="products.php">Products</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="about.php">About</a>
        </li>
        <li class="nav-item">
            <a class="btn mr-sm-4 btn-outline-dark" href="login.php">Sign In</a>
        </li>
    </ul>
    <form class="form-inline my-2 my-lg-0" action="search.php" method="POST">
        <input class="form-control mr-sm-1" type="search" placeholder="Search" id="search_term" name="search_term" aria-label="Search">
        <button class="btn btn-outline-success my-2 my-sm-0" type="submit" name="search" id="search">Search</button>
    </form>
    </div>
</nav>
<div class="alert alert-info" role="alert">
    <h4 class="alert-heading">Successfully logged out!</h4>
</div>
<div class='fixed-bottom'>
    <?= include_once("./template/footer.php"); ?>
</div>
<script src="assets/js/bootstrap.min.js"></script>
</body>

</html>