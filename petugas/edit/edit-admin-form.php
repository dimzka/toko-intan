<?php

function dbConnect() {
    $db = new mysqli("localhost", "root", "", "db_pdintan");
    if ($db->connect_errno) {
        die("Failed to connect to MySQL: " . $db->connect_error);
    }
    return $db;
}

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($id <= 0) {
    die("ID tidak valid.");
}

$db = dbConnect();

$query = "SELECT * FROM pengguna WHERE id_pengguna = ?";
$stmt = $db->prepare($query);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("Data pengguna tidak ditemukan.");
}

$user = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Pengguna</title>
    <link rel="stylesheet" href="../path/to/bootstrap.min.css">
</head>
<body>
    <div class="container mt-4">
        <h2>Edit Pengguna</h2>
        
        <!-- Tampilkan pesan jika ada -->
        <?php if (isset($_GET['message'])): ?>
        <div class="alert alert-info">
            <?php echo htmlspecialchars($_GET['message']); ?>
        </div>
        <?php endif; ?>

        <!-- Form edit data -->
        <form action="edit/edit-admin-process.php?id=<?php echo $id; ?>" method="post">
            <div class="form-group">
                <label for="nama">Nama:</label>
                <input type="text" id="nama" name="nama" class="form-control" value="<?php echo htmlspecialchars($user['nama']); ?>" required>
            </div>
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" class="form-control" value="<?php echo htmlspecialchars($user['username']); ?>" required>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" class="form-control" value="<?php echo htmlspecialchars($user['email']); ?>" required>
            </div>
            <div class="form-group">
                <label for="password">Password (kosongkan jika tidak diubah):</label>
                <input type="password" id="password" name="password" class="form-control">
            </div>
            <div class="form-group">
                <label for="jabatan">Jabatan:</label>
                <select id="jabatan" name="jabatan" class="form-control" required>
                    <option value="pemilik" <?php echo ($user['jabatan'] === 'pemilik') ? 'selected' : ''; ?>>Pemilik</option>
                    <option value="penjualan" <?php echo ($user['jabatan'] === 'penjualan') ? 'selected' : ''; ?>>Penjualan</option>
                    <option value="admin" <?php echo ($user['jabatan'] === 'admin') ? 'selected' : ''; ?>>Admin</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="index.php?page=data-admin" class="btn btn-secondary">Cancel</a>
        </form>
    </div>

    <script src="../path/to/bootstrap.bundle.min.js"></script>
</body>
</html>
