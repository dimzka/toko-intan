<div class="container mt-4">
    <h2 class="text-center">Produk</h2>
    <!-- Tabs -->
    <ul class="nav nav-tabs" id="productTabs" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" id="all-products-tab" data-toggle="tab" href="#all-products" role="tab" aria-controls="all-products" aria-selected="true">All Products</a>
        </li>
    </ul>
    <div class="tab-content" id="productTabsContent">
        <div class="tab-pane fade show active" id="all-products" role="tabpanel" aria-labelledby="all-products-tab">
            <div class="product-carousel mt-4">
                <?php if (!empty($products)): ?>
                    <?php foreach ($products as $product): ?>
                        <div class="card mb-4">
                            <img src="petugas/image/<?php echo htmlspecialchars($product['gambar']); ?>" class="card-img-top img-fluid" alt="<?php echo htmlspecialchars($product['nama']); ?>">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo htmlspecialchars($product['nama']); ?></h5>
                                <p class="card-text">Harga: Rp <?php echo number_format($product['harga'], 0, ',', '.'); ?></p>
                                <a href="add_to_cart.php?id_produk=<?php echo urlencode($product['id_produk']); ?>" class="btn btn-light">Add to Cart</a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="text-center">Tidak ada produk yang tersedia.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <?php include 'rekomendasi.php'; ?>
</div>

