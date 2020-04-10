<section class="container" id="cartItems">
    <div clas="row">
        <h2>Cart</h2>
    </div>
    <div class="row cartItemHeader">
        <div class="col-12 text-right">
            Price
        </div>
    </div>
    <?php foreach ($cartItems as $cartItem) : ?>
        <div class="row cartItem">
            <?php include __DIR__ . '/cartItem.php'; ?>
        </div>
    <?php endforeach; ?>
    <div class="row">
        <div class="col-12 text-right">
            Total (<?= $countCartItems ?> Product): <span class="price"><?= number_format($cartSum / 100, 2, ",", " ") ?> €</div>
    </div>
    </div>
    <div class="row">
        <a href="checkout.php" class="btn btn-primary col-12">Checkout</a>
    </div>
</section>