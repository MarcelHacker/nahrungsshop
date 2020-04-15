<div class="col-3">
    <div class="container ">
        <img src=" <?= $cartItem['source'] ?> " class="card-img-top" alt="product">
    </div>
</div>
<div class="col-7">
    <div><?= $cartItem['title'] ?></div>
    <div><?= $cartItem['description'] ?></div>
</div>
<div class="col-1 text-centre">
    <span class="quantity"><?= $cartItem['quantity'] ?></div>
<div class="col-1 text-right">
    <span class="price"><?= number_format($cartItem['price'], 2, ",", " ") ?> €
</div>