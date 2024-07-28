<?php
include('config/config.php');

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($id > 0) {
    $db = dbConnect();
    $query = "DELETE FROM pengguna WHERE id_pengguna = ?";
    $stmt = $db->prepare($query);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo "<script type='text/javascript'>
                alert('Data berhasil dihapus!');
                window.location='index.php?page=data-admin';
              </script>";
    } else {
        echo "<script type='text/javascript'>
                alert('Gagal menghapus data: " . addslashes($stmt->error) . "');
                window.location='index.php?page=data-admin';
              </script>";
    }

    $stmt->close();
    $db->close();
} else {
    echo "<script type='text/javascript'>
            alert('ID pengguna tidak valid!');
            window.location='index.php?page=data-admin';
          </script>";
}
?>
