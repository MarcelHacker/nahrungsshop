<?php
include_once("includes.php");

$userId = getCurrentUserId();
//$cartItems = countProductsInCart($userId); 



$search = $_GET["search"];
$sql = "SELECT id,title,description,price FROM products
        where title like '$search';";   
$products = getProducts($sql);

if(!$products)
{
    echo "Keine Produkte gefunden";
}
else
{
    echo "Es wurden folgende Produkte gefunden";
}
?>
<html>
    <body>
        <header>
            <section class="container" id="products">
                <div class="row">
                        <?php foreach($products as $product):?>
                <div class="col">
                        <?php include("template/card.php") ?>
                 </div>
                        <?php endforeach;?>
                </div>
        </header>

        <script src="assets/js/bootstrap.min.js"></script>
    </body>
</html>    