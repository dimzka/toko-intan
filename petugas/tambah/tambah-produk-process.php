<?php
include('../config/config.php');

// Ambil data dari form
$nama = $_POST['nama'];
$deskripsi = $_POST['deskripsi'];
$harga = $_POST['harga'];
$stok = $_POST['stok'];
$gambar = $_FILES['gambar']['name'];
$tmp = $_FILES['gambar']['tmp_name'];
$id_kategori = $_POST['id_kategori'];
$id_pengguna = $_POST['id_pengguna'];

// Validasi input
if (empty($nama) || empty($harga) || empty($stok)) {
    $message = 'Semua field harus diisi!';
    echo "<script type='text/javascript'>
            alert('$message');
            window.location='../index.php?page=tambah-produk';
          </script>";
    exit();
}

// Validasi upload file
if ($gambar) {
    $allowed_extensions = array('jpg', 'jpeg', 'png', 'gif');
    $extension = pathinfo($gambar, PATHINFO_EXTENSION);
    
    if (!in_array($extension, $allowed_extensions)) {
        $message = 'Ekstensi file tidak diizinkan!';
        echo "<script type='text/javascript'>
                alert('$message');
                window.location='../index.php?page=tambah-produk';
              </script>";
        exit();
    }

    $location = '../image/' . basename($gambar);
    if (!move_uploaded_file($tmp, $location)) {
        $message = 'Gagal meng-upload gambar!';
        echo "<script type='text/javascript'>
                alert('$message');
                window.location='../index.php?page=tambah-produk';
              </script>";
        exit();
    }
} else {
    $location = ''; // Jika tidak ada gambar di-upload
}

$db = dbConnect();
$query = "INSERT INTO produk (nama, deskripsi, harga, stok, gambar, id_kategori, id_pengguna) 
          VALUES (?, ?, ?, ?, ?, ?, ?)";
$stmt = $db->prepare($query);

if ($stmt === false) {
    $message = 'Gagal menyiapkan statement: ' . htmlspecialchars($db->error, ENT_QUOTES, 'UTF-8');
    echo "<script type='text/javascript'>
            alert('$message');
            window.location='../index.php?page=tambah-produk';
          </script>";
    exit();
}

$stmt->bind_param("ssiisii", $nama, $deskripsi, $harga, $stok, $gambar, $id_kategori, $id_pengguna);

if ($stmt->execute()) {
    $message = 'Produk berhasil ditambahkan!';
    echo "<script type='text/javascript'>
            alert('$message');
            window.location='../index.php?page=data-produk';
          </script>";
} else {
    $message = 'Gagal menambahkan produk: ' . htmlspecialchars($stmt->error, ENT_QUOTES, 'UTF-8');
    echo "<script type='text/javascript'>
            alert('$message');
            window.location='../index.php?page=tambah-produk';
          </script>";
}
$stmt->close();
$db->close();
?>
