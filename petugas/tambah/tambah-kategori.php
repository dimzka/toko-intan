<?php
$message = isset($_GET['message']) ? htmlspecialchars($_GET['message']) : '';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Kategori</title>
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
        <h2>Tambah Kategori</h2>
        <script>
            showAlert('<?php echo $message; ?>');
        </script>
        <form action="tambah/tambah-kategori-process.php" method="post">
            <div class="form-group">
                <label for="nama">Nama:</label>
                <input type="text" id="nama" name="nama" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="index.php?page=data-kategori" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
    <script src="../path/to/bootstrap.bundle.min.js"></script>
</body>
</html>
