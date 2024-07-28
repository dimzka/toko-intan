<?php
include('../config/config.php');

// Ambil data dari form
$nama = $_POST['nama'];

if (empty($nama)) {
    $message = 'Nama kategori harus diisi!';
    echo "<script type='text/javascript'>
            alert('$message');
            window.location='../index.php?page=tambah-kategori';
          </script>";
    exit();
} else {
    $db = dbConnect();
    $query = "INSERT INTO kategori (nama) VALUES (?)";
    $stmt = $db->prepare($query);
    $stmt->bind_param("s", $nama);

    if ($stmt->execute()) {
        $message = 'Kategori berhasil ditambahkan!';
        echo "<script type='text/javascript'>
                alert('$message');
                window.location='../index.php?page=data-kategori';
              </script>";
        exit();
    } else {
        $message = 'Gagal menambahkan kategori: ' . htmlspecialchars($stmt->error, ENT_QUOTES, 'UTF-8');
        echo "<script type='text/javascript'>
                alert('$message');
                window.location='../index.php?page=tambah-kategori';
              </script>";
        exit();
    }
}
?>
