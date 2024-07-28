<?php
include('../config/config.php');

// Ambil data dari form
$nama = $_POST['nama'];
$username = $_POST['username'];
$email = $_POST['email'];
$password = $_POST['password'];
$jabatan = $_POST['jabatan'];
$created_at = date('Y-m-d H:i:s'); // Tanggal dan waktu saat ini

// Validasi input (contoh sederhana, bisa dikembangkan lebih lanjut)
if (empty($nama) || empty($username) || empty($email) || empty($password) || empty($jabatan)) {
    // Redirect kembali ke halaman dengan pesan error
    header('Location: ../index.php?page=tambah-admin&message=' . urlencode('Semua field harus diisi!'));
    exit();
} else {
    // Koneksi ke database
    $db = dbConnect();

    // Enkripsi password
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    // Query untuk menyimpan data ke database
    $query = "INSERT INTO pengguna (nama, username, email, password, jabatan, created_at) 
              VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $db->prepare($query);
    $stmt->bind_param("ssssss", $nama, $username, $email, $hashed_password, $jabatan, $created_at);

    if ($stmt->execute()) {
        // Redirect ke halaman dengan pesan sukses
        ?>
        <script type="text/javascript">
            alert('Data berhasil ditambahkan!');
            window.location='../index.php?page=data-admin';
        </script>
        <?php
        exit();
    } else {
        ?>
        <script type="text/javascript">
            alert('Data gagal ditambahkan!');
            window.location='../index.php?page=data-admin';
        </script>
        <?php
        exit();
    }
}
