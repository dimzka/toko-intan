<?php 
include 'header.php';
include 'petugas/config/config.php';

// Connect to the database
$db = dbConnect();
if (!$db) {
    die("Database connection failed: " . $db->connect_error);
}

$cartItems = [];
$id_pelanggan = $_SESSION['id_pelanggan'] ?? null;

if ($id_pelanggan) {
    // Fetch cart and cart items
    $query = "SELECT p.id_produk, p.nama, p.harga, p.gambar, ci.jumlah, discount, id_cart_item
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
    }
}

$db->close();
function check_login() {

    if (!isset($_SESSION['id_pelanggan'])) {
        header('Location: login.php');
        exit();
    }
}
// Panggil fungsi cek login
check_login(); 
?>

<?php include 'navbar_categories.php'; ?>

<div class="container">
    <form method="post" action="prosesCheckout.php" enctype="multipart/form-data">
        <h1>Konfirmasi Transaksi</h1>
        <?php if (count($cartItems) > 0): ?>
            <?php $total = 0; ?>
            <?php foreach ($cartItems as $item): ?>
                <div class="cart-item d-flex align-items-center mb-2">
                    <img src="petugas/image/<?php echo htmlspecialchars($item['gambar']); ?>" alt="<?php echo htmlspecialchars($item['nama']); ?>" class="cart-item-img">
                    <div class="cart-item-info flex-grow-1 ml-2">
                        <div><?php echo htmlspecialchars($item['nama']); ?></div>
                        <div>Rp 
                            <?php if($item['discount'] == 1) : ?>
                                <?php $total += $item['harga'] * $item['jumlah'] - ($item['harga'] * $item['jumlah'] * 0.1); ?>
                                <del><?= number_format($item['harga'], 0, ',', '.');?></del> 
                                <?php echo number_format($item['harga'] - ($item['harga'] * 0.1), 0, ',', '.'); ?>
                            <?php else : ?>
                                <?php $total += $item['harga'] * $item['jumlah']; ?>
                                <?php echo number_format($item['harga'], 0, ',', '.'); ?>
                            <?php endif; ?>
                        </div>
                        <div>Jumlah: 
                            <input type="number" value="<?php echo $item['jumlah']; ?>" name="quantity" onchange="updateQuantity(this, '<?php echo $item['id_cart_item']; ?>')">
                        </div>
                    </div>
                    <button class="btn btn-danger btn-sm btn-remove" data-id="<?php echo htmlspecialchars($item['id_produk']); ?>" onclick="setTimeout(function() { window.location.reload(); }, 500)">Hapus</button>
                </div>
            <?php endforeach; ?>
            <div class="dropdown-divider"></div>
            <div class="row">
                <div class="col-md-12">
                    <label class="form-label">Bukti Pembayaran</label>
                    <input type="file" class="form-control" name="bukti" required>
                </div>
                <div class="col-md-6">
                    <h5 class="mt-3">Tanggal: <?php echo date('Y-m-d'); ?></h5>
                </div>
                <div class="col-md-6">
                    <h5 class="mt-3">Total: Rp <?php echo number_format($total, 0, ',', '.'); ?></h5>
                </div>
            </div>
            
            <div class="float-right">
                <a class="btn btn-danger" href="cart.php">Batal</a>
                <input class="btn btn-primary" type="submit" name="submit" value="Checkout" />
            </div>
        <?php else: ?>
            <div class="text-center">No items in cart</div>
        <?php endif; ?>
    </form>
</div>
<script>
    function updateQuantity(input, id) {
        fetch('cart.php?id=' + id + '&quantity=' + input.value)
        setTimeout(function() { window.location.reload(); }, 500)
    }
</script>


<?php include 'footer.php'; ?>
