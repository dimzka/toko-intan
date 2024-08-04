<?php
include 'petugas/config/config.php';

session_start();

if (isset($_POST['kirim'])) {

    $kritik = $_POST['kritik'];
    $saran = $_POST['saran'];
    $db = dbConnect();

    $query = "INSERT INTO keluhan (id_pelanggan, kritik, saran) VALUES (?, ?, ?)";

    if (!$query) {
        die("Query Failed!");
    }

    $stmt = $db->prepare($query);
    $stmt->bind_param('iss', $_SESSION['id_pelanggan'], $kritik, $saran);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        $_SESSION['message'] = "Data berhasil ditambahkan!";
        $_SESSION['message_type'] = "success";
    } else {
        $_SESSION['message'] = "Data gagal ditambahkan!";
        $_SESSION['message_type'] = "danger";
    }

    header("Location: index.php");
    exit();
}
