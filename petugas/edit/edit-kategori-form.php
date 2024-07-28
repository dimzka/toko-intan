<?php
include('config/config.php');

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($id <= 0) {
    die("ID tidak valid.");
}

$db = dbConnect();
$query = "SELECT * FROM kategori WHERE id_kategori = ?";
$stmt = $db->prepare($query);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("Data kategori tidak ditemukan.");
}

$category = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Kategori</title>
    <link rel="stylesheet" href="../path/to/bootstrap.min.css">
</head>
<body>
    <div class="container mt-4">
        <h2>Edit Kategori</h2>
        <?php if (isset($_GET['message'])): ?>
        <div class="alert alert-info">
            <?php echo htmlspecialchars($_GET['message']); ?>
        </div>
        <?php endif; ?>
        <form action="edit/edit-kategori-process.php?id=<?php echo $id; ?>" method="post">
            <div class="form-group">
                <label for="nama">Nama:</label>
                <input type="text" id="nama" name="nama" class="form-control" value="<?php echo htmlspecialchars($category['nama']); ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="index.php?page=data-kategori" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
    <script src="../path/to/bootstrap.bundle.min.js"></script>
</body>
</html>
