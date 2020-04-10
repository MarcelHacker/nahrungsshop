<?php
session_start();
session_unset();
session_destroy();
include_once("template/header.php");
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
    <form class="form-inline my-2 my-lg-0" action="search.php" method="GET">
        <input class="form-control mr-sm-1" type="search" placeholder="Search" aria-label="Search">
        <button class="btn btn-outline-success my-2 my-sm-0" type="submit" name="search" id="search">Search</button>
    </form>
    </div>
</nav>
<div class="modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Logout</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Sucessfully logged out!</p>
            </div>
            <div class="modal-footer">
                <button href="index.php" type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class='fixed-bottom'>
    <?= include_once("template/footer.php"); ?>
</div>
<script src="assets/js/bootstrap.min.js"></script>
</body>

</html>