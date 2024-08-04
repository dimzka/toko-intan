<?php 
include 'header.php';
include 'petugas/config/config.php';

// Connect to the database
$db = dbConnect();
if (!$db) {
    die("Database connection failed: " . $db->connect_error);
}

$history = [];
$id_pelanggan = $_SESSION['id_pelanggan'] ?? null;

if ($id_pelanggan) {
    // Fetch cart and cart items
    $query = "SELECT bukti.*, t.*, bukti.status
            FROM bukti
            JOIN transaksi t ON bukti.id_transaksi = t.id_transaksi
            WHERE t.id_pelanggan = ?
            ORDER BY id desc";
    $stmt = $db->prepare($query);
    $stmt->bind_param('i', $id_pelanggan);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $history[] = $row;
        }
    }
}

?>

<?php include 'navbar_categories.php'; ?>

<div class="container">
    <form method="post" action="prosesCheckout.php" enctype="multipart/form-data">
        <h1>History Transaksi</h1>
        <?php if (count($history) > 0): ?>
            <?php foreach ($history as $item): ?>
                <?php
                    $detailTransaksi = [];

                    $query = "SELECT * FROM detail_transaksi LEFT JOIN produk ON detail_transaksi.id_produk = produk.id_produk WHERE id_transaksi = ?";
                    $stmt = $db->prepare($query);
                    $stmt->bind_param('i', $item['id_transaksi']);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            $detailTransaksi[] = $row;
                        }
                    }
                ?>
                <div class="row">
                    <div class="col-md-6">
                        <?php foreach ($detailTransaksi as $item2): ?>
                            <div class="cart-item d-flex align-items-center mb-2">
                                <img src="petugas/image/<?php echo htmlspecialchars($item2['gambar']); ?>" alt="<?php echo htmlspecialchars($item2['nama']); ?>" class="cart-item-img">
                                <div class="cart-item-info flex-grow-1 ml-2">
                                    <div><?php echo htmlspecialchars($item2['nama']); ?></div>
                                    <div>Rp <?php echo number_format($item2['harga'], 0, ',', '.'); ?></div>
                                    <div>Jumlah: <?php echo htmlspecialchars($item2['jumlah']); ?></div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <div class="col-md-6 text-center">
                        <img src="uploads/<?= $item['file'] ?>" alt="<?php echo htmlspecialchars($item['file']); ?>" class="img-fluid">
                    </div>
                    <div class="col-md-12">
                        <div class="float-right">
                            <h5>Transaksi tanggal <?php echo htmlspecialchars($item['tanggal']); ?></h5>
                            <h5>Total Harga: Rp <?php echo number_format($item['total'], 0, ',', '.'); ?></h5>
                            <h5>Status Pembayaran 
                                <?php
                                    if($item['status'] == 0){
                                        echo "Pending";
                                    }else if($item['status'] == 1){
                                        echo "Dibayar";
                                    }else {
                                        echo "Dibatalkan";
                                    }
                                ?>
                            </h5>
                        </div>
                    </div>
                </div>
                
                <div class="dropdown-divider"></div>
            <?php endforeach; ?>
        
        <?php else: ?>
            <div class="text-center">No items in history</div>
        <?php endif; ?>
    </form>
</div>


<?php include 'footer.php'; ?>
