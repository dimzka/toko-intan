<?php
include('config/config.php');

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($id <= 0) {
    die("ID tidak valid.");
}

$db = dbConnect();
$query = "SELECT * FROM produk WHERE id_produk = ?";
$stmt = $db->prepare($query);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("Data produk tidak ditemukan.");
}

$product = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Produk</title>
    <link rel="stylesheet" href="../path/to/bootstrap.min.css">
</head>
<body>
    <div class="container mt-4">
        <h2>Edit Produk</h2>
        <?php if (isset($_GET['message'])): ?>
        <div class="alert alert-info">
            <?php echo htmlspecialchars($_GET['message']); ?>
        </div>
        <?php endif; ?>
        <form action="edit/edit-produk-process.php?id=<?php echo $id; ?>" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="nama">Nama:</label>
                <input type="text" id="nama" name="nama" class="form-control" value="<?php echo htmlspecialchars($product['nama']); ?>" required>
            </div>
            <div class="form-group">
                <label for="deskripsi">Deskripsi:</label>
                <textarea id="deskripsi" name="deskripsi" class="form-control" required><?php echo htmlspecialchars($product['deskripsi']); ?></textarea>
            </div>
            <div class="form-group">
                <label for="harga">Harga:</label>
                <input type="number" id="harga" name="harga" class="form-control" value="<?php echo htmlspecialchars($product['harga']); ?>" required>
            </div>
            <div class="form-group">
                <label for="stok">Stok:</label>
                <input type="number" id="stok" name="stok" class="form-control" value="<?php echo htmlspecialchars($product['stok']); ?>" required>
            </div>
            <div class="form-group">
                <label for="gambar">Gambar:</label>
                <input type="file" id="gambar" name="gambar" class="form-control">
                <?php if ($product['gambar']): ?>
                <img src="image/<?php echo htmlspecialchars($product['gambar']); ?>" alt="Gambar Produk" width="100">
                <?php endif; ?>
            </div>
            <input type="hidden" name="id_pengguna" value="<?php echo $_SESSION['Id_pengguna']; ?>">
            <div class="form-group">
                <label for="kategori">Kategori:</label>
                <select id="kategori" name="kategori" class="form-control" required>
                    <?php
                    $cat_query = "SELECT * FROM kategori";
                    $cat_result = $db->query($cat_query);
                    while ($cat_row = $cat_result->fetch_assoc()) {
                        $selected = ($cat_row['id_kategori'] == $product['id_kategori']) ? 'selected' : '';
                        echo '<option value="' . $cat_row['id_kategori'] . '" ' . $selected . '>' . htmlspecialchars($cat_row['nama']) . '</option>';
                    }
                    ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="index.php?page=data-produk" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
    <script src="../path/to/bootstrap.bundle.min.js"></script>
</body>
</html>
