<?php
include('../config/config.php');

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($id > 0) {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $nama = $_POST['nama'];

        if (empty($nama)) {
            $message = 'Nama kategori harus diisi!';
            echo "<script type='text/javascript'>
                    alert('$message');
                    window.location='../index.php?page=edit-kategori&id=$id';
                  </script>";
            exit();
        } else {
            $db = dbConnect();
            $query = "UPDATE kategori SET nama = ? WHERE id_kategori = ?";
            $stmt = $db->prepare($query);
            $stmt->bind_param("si", $nama, $id);

            if ($stmt->execute()) {
                $message = 'Kategori berhasil diperbarui!';
                echo "<script type='text/javascript'>
                        alert('$message');
                        window.location='../index.php?page=data-kategori';
                      </script>";
                exit();
            } else {
                $message = 'Gagal memperbarui kategori: ' . htmlspecialchars($stmt->error, ENT_QUOTES, 'UTF-8');
                echo "<script type='text/javascript'>
                        alert('$message');
                        window.location='../index.php?page=edit-kategori&id=$id';
                      </script>";
                exit();
            }
        }
    } else {
        die("Invalid request method.");
    }
} else {
    echo "<script type='text/javascript'>
            alert('ID kategori tidak valid!');
            window.location='../index.php?page=data-kategori';
          </script>";
}
?>
