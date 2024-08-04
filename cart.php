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
    $query = "SELECT p.id_produk, p.nama, p.harga, p.gambar, ci.jumlah, discount, ci.id_cart_item
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

if(isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "UPDATE cart_item SET jumlah = $_GET[quantity] WHERE id_cart_item = ?";
    $stmt = $db->prepare($query);
    $stmt->bind_param('i', $id);
    $stmt->execute();
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
    <?php if (count($cartItems) > 0): ?>
        <?php foreach ($cartItems as $item): ?>
            <div class="cart-item d-flex align-items-center mb-2">
                <img src="petugas/image/<?php echo htmlspecialchars($item['gambar']); ?>" alt="<?php echo htmlspecialchars($item['nama']); ?>" class="cart-item-img">
                <div class="cart-item-info flex-grow-1 ml-2">
                    <div><?php echo htmlspecialchars($item['nama']); ?></div>
                    <div>Rp 
                        <?php if($item['discount'] == 1) : ?>
                            <del><?= number_format($item['harga'], 0, ',', '.');?></del> 
                            <?php echo number_format($item['harga'] - ($item['harga'] * 0.1), 0, ',', '.'); ?>
                        <?php else : ?>
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
        <a class="dropdown-item" href="transaksi.php">Proceed to Checkout</a>
    <?php else: ?>
        <div class="text-center">No items in cart</div>
    <?php endif; ?>
</div>
<script>
    function updateQuantity(input, id) {
        fetch('cart.php?id=' + id + '&quantity=' + input.value)
    }
</script>


<?php include 'footer.php'; ?>
