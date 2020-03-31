<?php
include_once("includes.php");

$userId = getCurrentUserId();
$cartItems = countProductsInCart($userId); 

function getPage()
{
    return "products";
} 
include_once("templates/navbar.php");
$products = getAllProducts(); 
?>
<html>
    <body>

        <header>
            <section class="container" id="products">
                <div class="row">
                        <?php foreach($products as $product):?>
                <div class="col">
                        <?php include("templates/card.php") ?>
                 </div>
                        <?php endforeach;?>
                </div>
        </header>

        <script src="assets/js/bootstrap.min.js"></script>
    </body>
</html>    
    