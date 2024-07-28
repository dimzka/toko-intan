<?php
include('../config/config.php');

// Ambil ID produk dari parameter URL
$id_produk = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($id_produk <= 0) {
    die("ID tidak valid.");
}

// Ambil data dari form
$nama = $_POST['nama'];
$deskripsi = $_POST['deskripsi'];
$harga = $_POST['harga'];
$stok = $_POST['stok'];
$gambar = $_FILES['gambar']['name'];
$tmp = $_FILES['gambar']['tmp_name'];
$id_kategori = $_POST['kategori']; // Disesuaikan dengan nama field di form
$id_pengguna = $_POST['id_pengguna'];

// Validasi input
if (empty($nama) || empty($harga) || empty($stok)) {
    $message = 'Semua field harus diisi!';
    echo "<script type='text/javascript'>
            alert('$message');
            window.location='../index.php?page=edit-produk&id=$id_produk';
          </script>";
    exit();
}

// Koneksi ke database
$db = dbConnect();

// Validasi upload file
if ($gambar) {
    $allowed_extensions = array('jpg', 'jpeg', 'png', 'gif');
    $extension = pathinfo($gambar, PATHINFO_EXTENSION);
    
    if (!in_array($extension, $allowed_extensions)) {
        $message = 'Ekstensi file tidak diizinkan!';
        echo "<script type='text/javascript'>
                alert('$message');
                window.location='../index.php?page=edit-produk&id=$id_produk';
              </script>";
        exit();
    }

    $location = '../image/' . basename($gambar);
    if (!move_uploaded_file($tmp, $location)) {
        $message = 'Gagal meng-upload gambar!';
        echo "<script type='text/javascript'>
                alert('$message');
                window.location='../index.php?page=edit-produk&id=$id_produk';
              </script>";
        exit();
    }
} else {
    // Jika tidak ada gambar baru di-upload, ambil gambar lama dari database
    $query = "SELECT gambar FROM produk WHERE id_produk = ?";
    $stmt = $db->prepare($query);
    $stmt->bind_param("i", $id_produk);
    $stmt->execute();
    $result = $stmt->get_result();
    $product = $result->fetch_assoc();
    $gambar = $product['gambar'];
    $stmt->close();
}

// Query update produk
$query = "UPDATE produk SET nama = ?, deskripsi = ?, harga = ?, stok = ?, gambar = ?, id_kategori = ?, id_pengguna = ? WHERE id_produk = ?";
$stmt = $db->prepare($query);

if ($stmt === false) {
    $message = 'Gagal menyiapkan statement: ' . htmlspecialchars($db->error, ENT_QUOTES, 'UTF-8');
    echo "<script type='text/javascript'>
            alert('$message');
            window.location='../index.php?page=edit-produk&id=$id_produk';
          </script>";
    exit();
}

$stmt->bind_param("ssiisiii", $nama, $deskripsi, $harga, $stok, $gambar, $id_kategori, $id_pengguna, $id_produk);

if ($stmt->execute()) {
    $message = 'Produk berhasil diperbarui!';
    echo "<script type='text/javascript'>
            alert('$message');
            window.location='../index.php?page=data-produk';
          </script>";
} else {
    $message = 'Gagal memperbarui produk: ' . htmlspecialchars($stmt->error, ENT_QUOTES, 'UTF-8');
    echo "<script type='text/javascript'>
            alert('$message');
            window.location='../index.php?page=edit-produk&id=$id_produk';
          </script>";
}

$stmt->close();
$db->close();
?>
