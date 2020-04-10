<div class="container p-3">
    <div class="card p-1">
        <div class="card-title"><?= $product['title'] ?> Produkt ID= <?= $product['id'] ?></div>
        <img src=" <?= $product['source'] ?> " class="card-img-top" alt="produkt">
        <div class="card-body">
            <?= $product['description'] ?>
            <hr>
            <?= $product['price'] ?> €
        </div>
        <div class="card-footer">
            <form action="products.php" method="GET">
                <a href="products.php?details=<?= $product['id'] ?>" class="btn btn-primary btn-sm p-1">Details</a>
            </form>
            <form action="products.php" method="GET">
                <a href="products.php?add=<?= $product['id'] ?>" class="btn btn-success btn-sm p-1">Add to cart</a>
            </form>
        </div>
    </div>
</div>