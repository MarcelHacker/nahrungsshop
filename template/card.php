<div class="container">
    <div class="card">
        <div class="card-title"><?= $product['title'] ?> Produkt ID= <?= $product['id'] ?></div>
        <img src=" <?= $product['source'] ?> " class="card-img-top" alt="produkt">
        <div class="card-body">
            <?= $product['description'] ?>
            <hr>
            <?= $product['price'] ?> €
        </div>
        <div class="card-footer">
            <form action="cart.php" method="POST">
                <a href="cart.php?id=<?= $product['id'] ?>" class="btn btn-primary btn-sm">Details</a>
            </form>
            <form action="cart.php" method="POST">
                <a href="cart.php?id=<?= $product['id'] ?>" class="btn btn-success btn-sm">Add to cart</a>
            </form>
        </div>
    </div>
</div>