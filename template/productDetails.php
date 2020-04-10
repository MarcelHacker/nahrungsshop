<div class="container p-2">
    <div class="card mb-3" style="max-width: 600px;">
        <div class="row no-gutters">
            <div class="col-md-4">
                <img src=" <?= $product['source'] ?>" class="card-img" alt="...">
            </div>
            <div class="col-md-8">
                <div class="card-body">
                    <h5 class="card-title"><?= $product['title'] ?></h5>
                    <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
                    <p class="card-text"><small class="text-muted">In Stock</small></p>
                </div>
            </div>
            <div class="card-footer">
                <div class="col-md-10">
                    <a href="products.php" class="btn btn-primary btn-md">Back</a>
                    <form action="products.php" method="GET">
                        <a href="products.php?add=<?= $product['id'] ?>" class="btn btn-success btn-md">Add to cart</a>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>