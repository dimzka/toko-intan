<?php
    include 'petugas/config/config.php';

    // Connect to the database
    $db = dbConnect();
    $id_pelanggan = $_SESSION['id_pelanggan'];

    // Get rekomendasi today
    $query = "SELECT * FROM rekomendasi_produk 
        JOIN produk ON rekomendasi_produk.id_produk = produk.id_produk
        WHERE id_pelanggan = ?
        AND DAY(tanggal_rekomendasi) = DAY(NOW())
        AND MONTH(tanggal_rekomendasi) = MONTH(NOW()) 
        AND YEAR(tanggal_rekomendasi) = YEAR(NOW())";

    $stmt = $db->prepare($query);
    $stmt->bind_param('i', $id_pelanggan);
    $stmt->execute();
    $result = $stmt->get_result();

    $productRecomendation = [];
    while ($row = $result->fetch_assoc()) {
        $productRecomendation[] = $row;
    }
?>
<?php if($result->num_rows > 0): ?>
    <h2 class="text-center">Rekomedasi</h2>
    <ul class="nav nav-tabs" id="productTabs" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" id="all-products-tab" data-toggle="tab" href="#all-products" role="tab" aria-controls="all-products" aria-selected="true">All Products</a>
        </li>
    </ul>
    <div class="tab-content" id="productTabsContent">
        <div class="tab-pane fade show active" id="all-products" role="tabpanel" aria-labelledby="all-products-tab">
            <div class="product-carousel mt-4">
                <?php foreach ($productRecomendation as $product): ?>
                    <div class="card mb-4">
                        <img src="petugas/image/<?php echo htmlspecialchars($product['gambar']); ?>" class="card-img-top img-fluid" alt="<?php echo htmlspecialchars($product['nama']); ?>">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo htmlspecialchars($product['nama']); ?></h5>
                            <p class="card-text">Harga: Rp <?php echo number_format($product['harga'], 0, ',', '.'); ?></p>
                            <a href="add_to_cart.php?id_produk=<?php echo urlencode($product['id_produk']); ?>" class="btn btn-light">Add to Cart</a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
<?php endif; ?>