<?php
include('../config/config.php');

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($id > 0) {
    $db = dbConnect();
    $query = "DELETE FROM produk WHERE id_produk = ?";
    $stmt = $db->prepare($query);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        $message = 'Produk berhasil dihapus!';
        echo "<script type='text/javascript'>
                alert('$message');
                window.location='../index.php?page=data-produk';
              </script>";
    } else {
        $message = 'Gagal menghapus produk: ' . htmlspecialchars($stmt->error, ENT_QUOTES, 'UTF-8');
        echo "<script type='text/javascript'>
                alert('$message');
                window.location='../index.php?page=data-produk';
              </script>";
    }

    $stmt->close();
    $db->close();
} else {
    $message = 'ID produk tidak valid!';
    echo "<script type='text/javascript'>
            alert('$message');
            window.location='../index.php?page=data-produk';
          </script>";
}
?>
