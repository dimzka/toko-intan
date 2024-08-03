<?php
include 'petugas/config/config.php';

// Connect to the database
$db = dbConnect();
if (!$db) {
    die("Database connection failed: " . $db->connect_error);
}

// Fetch categories for the navbar
$query = "SELECT * FROM kategori";
$result = $db->query($query);
if (!$result) {
    die("Query Error: " . $db->error);
}
$categories = [];
while ($row = $result->fetch_assoc()) {
    $categories[] = $row;
}

// Fetch products based on selected category
$category_id = isset($_GET['id_kategori']) ? (int)$_GET['id_kategori'] : 0;

// Fetch products for the selected category
$query = "SELECT * FROM produk WHERE id_kategori = ?";
$stmt = $db->prepare($query);
$stmt->bind_param('i', $category_id);
$stmt->execute();
$result = $stmt->get_result();
$products2 = [];
while ($row = $result->fetch_assoc()) {
    $products2[] = $row;
}

// Fetch cart items if user is logged in
$cartItems = [];
$cartItemCount = 0;
if (isset($_SESSION['id_pelanggan'])) {
    $id_pelanggan = $_SESSION['id_pelanggan'];

    // Fetch cart and cart items
    $query = "SELECT p.id_produk, p.nama, p.harga, p.gambar, ci.jumlah
              FROM cart c
              JOIN cart_item ci ON c.id_cart = ci.id_cart
              JOIN produk p ON ci.id_produk = p.id_produk
              WHERE c.id_pelanggan = ?";
    $stmt = $db->prepare($query);
    $stmt->bind_param('i', $id_pelanggan);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $cartItems = $result->fetch_all(MYSQLI_ASSOC);
        $cartItemCount = array_sum(array_column($cartItems, 'jumlah'));
    }
}

$db->close();
?>

<!DOCTYPE html>
<html lang="id">
<?php include 'header.php'; ?>

<body>
    <!-- Categories will be displayed here -->
    <?php include 'navbar_categories.php'; ?>
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
                    <?php if (!empty($products2)) : ?>
                        <?php foreach ($products2 as $product) : ?>
                            <div class="card mb-4">
                                <img src="petugas/image/<?php echo htmlspecialchars($product['gambar']); ?>" class="card-img-top img-fluid" alt="<?php echo htmlspecialchars($product['nama']); ?>">
                                <div class="card-body">
                                    <h5 class="card-title"><?php echo htmlspecialchars($product['nama']); ?></h5>
                                    <p class="card-text">Harga: Rp <?php echo number_format($product['harga'], 0, ',', '.'); ?>
                                    </p>
                                    <a href="add_to_cart.php?id_produk=<?php echo urlencode($product['id_produk']); ?>" class="btn btn-light">Add to Cart</a>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <p class="text-center">Tidak ada produk yang tersedia.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <?php include 'footer.php'; ?>
</body>

</html>