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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = $_POST['nama'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $jabatan = $_POST['jabatan'];

    if (empty($nama) || empty($username) || empty($email) || empty($jabatan)) {
        $message = 'Semua field harus diisi!';
        echo "<script type='text/javascript'>
                alert('$message');
                window.location='../index.php?page=edit-admin&id=$id';
              </script>";
        exit();
    } else {
        $db = dbConnect();
        
        // Check if password needs to be updated
        if (!empty($password)) {
            $hashed_password = password_hash($password, PASSWORD_BCRYPT);
            $query = "UPDATE pengguna SET nama = ?, username = ?, email = ?, password = ?, jabatan = ? WHERE id_pengguna = ?";
            $stmt = $db->prepare($query);
            $stmt->bind_param("sssssi", $nama, $username, $email, $hashed_password, $jabatan, $id);
        } else {
            $query = "UPDATE pengguna SET nama = ?, username = ?, email = ?, jabatan = ? WHERE id_pengguna = ?";
            $stmt = $db->prepare($query);
            $stmt->bind_param("ssssi", $nama, $username, $email, $jabatan, $id);
        }

        if ($stmt->execute()) {
            $message = 'Data berhasil diperbarui!';
            echo "<script type='text/javascript'>
                    alert('$message');
                    window.location='../index.php?page=data-admin';
                  </script>";
            exit();
        } else {
            $message = 'Gagal memperbarui data: ' . $stmt->error;
            echo "<script type='text/javascript'>
                    alert('$message');
                    window.location='../index.php?page=edit-admin&id=$id';
                  </script>";
            exit();
        }
    }
} else {
    die("Invalid request method.");
}
?>
