<?php
include('../config/config.php');

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($id > 0) {
    $db = dbConnect();
    $query = "DELETE FROM kategori WHERE id_kategori = ?";
    $stmt = $db->prepare($query);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        $message = 'Kategori berhasil dihapus!';
        echo "<script type='text/javascript'>
                alert('$message');
                window.location='../index.php?page=data-kategori';
              </script>";
    } else {
        $message = 'Gagal menghapus kategori: ' . htmlspecialchars($stmt->error, ENT_QUOTES, 'UTF-8');
        echo "<script type='text/javascript'>
                alert('$message');
                window.location='../index.php?page=data-kategori';
              </script>";
    }

    $stmt->close();
    $db->close();
} else {
    $message = 'ID kategori tidak valid!';
    echo "<script type='text/javascript'>
            alert('$message');
            window.location='../index.php?page=data-kategori';
          </script>";
}
?>
