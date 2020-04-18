<div class="col-3">
    <div class="container ">
        <img src=" <?= $cartItem['source'] ?> " class="card-img-top" alt="product">
    </div>
</div>
<div class="col-7">
    <div class="row-lg"><?= $cartItem['title'] ?></div>
    <div class="row-lg"><?= $categorie['title'] ?></div>
    <div class="row-lg"><?= $cartItem['description'] ?></div>
</div>
<div class="col-1 text-centre">
    <span class="quantity"><?= $cartItem['quantity'] ?></span></div>
<div class="col-1 text-right">
    <span class="price" style="color :red"><?= number_format($cartItem['price'], 2, ",", " ") ?> €</span>
</div>
<div class="col-1 text-right p-2">
    <a href="cart.php?plus=<?php echo $cartItem["product_id"] ?>"><i class="fas fa-plus"></i></a>
    <a href="cart.php?del=<?php echo $cartItem["id"] ?>"><i class="fas fa-trash"></i></a>
</div>