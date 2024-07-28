<?php
include('config/config.php');

// Inisialisasi variabel pesan
$message = isset($_GET['message']) ? htmlspecialchars($_GET['message']) : '';

// Koneksi ke database
$db = dbConnect();

// Query untuk mengambil data kategori
$cat_query = "SELECT * FROM kategori";
$cat_result = $db->query($cat_query);
if (!$cat_result) {
    die("Query Error: " . $db->error);
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Produk</title>
    <link rel="stylesheet" href="../path/to/bootstrap.min.css">
    <script>
        function showAlert(message) {
            if (message) {
                alert(message);
            }
        }
    </script>
</head>
<body>
    <div class="container mt-4">
        <h2>Tambah Produk</h2>
        <script>
            showAlert('<?php echo $message; ?>');
        </script>
        <form action="tambah/tambah-produk-process.php" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="nama">Nama:</label>
                <input type="text" id="nama" name="nama" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="deskripsi">Deskripsi:</label>
                <textarea id="deskripsi" name="deskripsi" class="form-control" required></textarea>
            </div>
            <div class="form-group">
                <label for="harga">Harga:</label>
                <input type="number" id="harga" name="harga" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="stok">Stok:</label>
                <input type="number" id="stok" name="stok" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="gambar">Gambar:</label>
                <input type="file" id="gambar" name="gambar" class="form-control">
            </div>
            <input type="hidden" name="id_pengguna" value="<?php echo $_SESSION['Id_pengguna']; ?>">
            <div class="form-group">
                <label for="id_kategori">Kategori:</label>
                <select id="id_kategori" name="id_kategori" class="form-control" required>
                    <?php
                    while ($cat_row = $cat_result->fetch_assoc()) {
                        echo '<option value="' . $cat_row['id_kategori'] . '">' . htmlspecialchars($cat_row['nama']) . '</option>';
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
