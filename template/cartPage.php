<section class="container" id="cartItems">
    <div class="row">
        <h2>Cart</h2>
    </div>
    <div class="row cartItemHeader">
        <div class="col-12">
            <div class="text-right">
                Price
            </div>
        </div>

    </div>

    </div>
    <?php foreach ($cartItems as $cartItem) : ?>
        <div class="row cartItem">
            <?php include("cartItem.php"); ?>
        </div>
    <?php endforeach; ?>
    <div class="row">
        <div class="col-12 text-right">
            Total (<?= $countCartItems ?> Products): <span class="price"><?= number_format($cartSum, 2, ",", " ") ?> €</div>
    </div>
    </div>
    <div class="row">
        <a href="checkout.php" class="btn btn-primary col-12">Checkout</a>
    </div>
</section>