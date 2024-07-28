<?php
// Ambil pesan dari query string jika ada
$message = isset($_GET['message']) ? htmlspecialchars($_GET['message']) : '';
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Pengguna</title>
    <link rel="stylesheet" href="../path/to/bootstrap.min.css">
    <script>
        // Fungsi untuk menampilkan alert jika ada pesan
        function showAlert(message) {
            if (message) {
                alert(message);
            }
        }
    </script>
</head>
<body>
    <div class="container mt-4">
        <h2>Tambah Pengguna</h2>

        <!-- Tampilkan pesan jika ada -->
        <script>
            // Tampilkan alert jika ada pesan dari query string
            showAlert('<?php echo $message; ?>');
        </script>

        <!-- Form tambah data -->
        <form action="tambah/tambah-admin-process.php" method="post" novalidate>
            <div class="form-group">
                <label for="nama">Nama:</label>
                <input type="text" id="nama" name="nama" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="jabatan">Jabatan:</label>
                <select id="jabatan" name="jabatan" class="form-control" required>
                    <option value="">Pilih Jabatan</option>
                    <option value="pemilik">Pemilik</option>
                    <option value="penjualan">Penjualan</option>
                    <option value="admin">Admin</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="index.php?page=data-admin" class="btn btn-secondary">Cancel</a>
        </form>
    </div>

    <script src="../path/to/bootstrap.bundle.min.js"></script>
</body>
</html>
