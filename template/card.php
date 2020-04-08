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
            <a href="index.php/product/details/<?= $product['id'] ?>" class="btn btn-primary btn-sm">Details</a>
            <a href="index.php/cart/add/<?= $product['id'] ?>" class="btn btn-success btn-sm">Add to cart</a>
        </div>
    </div>
</div>