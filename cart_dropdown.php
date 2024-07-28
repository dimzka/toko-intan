<?php
session_start();
include 'petugas/config/config.php';

// Connect to the database
$db = dbConnect();
if (!$db) {
    die("Database connection failed: " . $db->connect_error);
}

$cartItems = [];
if (isset($_SESSION['id_pelanggan'])) {
    $id_pelanggan = $_SESSION['id_pelanggan'];

    // Fetch cart and cart items
    $query = "SELECT p.id_produk, p.nama, p.harga, p.gambar, ci.jumlah
              FROM cart c
              JOIN cart_item ci ON c.id_cart = ci.id_cart
              JOIN produk p ON ci.id_produk = p.id_produk
              WHERE c.id_pelanggan = ?";
    $stmt = $db->prepare($query);
    if (!$stmt) {
        die("Prepare failed: " . $db->error);
    }
    $stmt->bind_param('i', $id_pelanggan);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $cartItems = $result->fetch_all(MYSQLI_ASSOC);
    }
}

$stmt->close();
$db->close();
?>

<?php if (!empty($cartItems)): ?>
    <?php foreach ($cartItems as $item): ?>
        <div class="cart-item">
            <?php
            $imagePath = 'petugas/image/' . htmlspecialchars($item['gambar']);
            if (file_exists($imagePath)): ?>
                <img src="<?php echo htmlspecialchars($imagePath); ?>" alt="<?php echo htmlspecialchars($item['nama']); ?>">
            <?php else: ?>
                <img src="petugas/image/default.jpg" alt="Default Image">
            <?php endif; ?>
            <div class="cart-item-info">
                <h6><?php echo htmlspecialchars($item['nama']); ?></h6>
                <p>Rp <?php echo number_format($item['harga'], 0, ',', '.'); ?> x <?php echo htmlspecialchars($item['jumlah']); ?></p>
            </div>
        </div>
    <?php endforeach; ?>
<?php else: ?>
    <p class="text-center">Keranjang Anda kosong.</p>
<?php endif; ?>
