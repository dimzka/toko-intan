<?php
session_start();
include 'petugas/config/config.php';

if (!isset($_GET['id_produk']) || !isset($_SESSION['id_pelanggan'])) {
    die("Invalid request");
}

$id_produk = intval($_GET['id_produk']);
$id_pelanggan = $_SESSION['id_pelanggan'];

// Connect to the database
$db = dbConnect();
if (!$db) {
    die("Database connection failed: " . $db->connect_error);
}

// Delete the item from the cart
$query = "DELETE ci FROM cart_item ci
          JOIN cart c ON ci.id_cart = c.id_cart
          WHERE c.id_pelanggan = ? AND ci.id_produk = ?";
$stmt = $db->prepare($query);
$stmt->bind_param('ii', $id_pelanggan, $id_produk);
$stmt->execute();

$db->close();
?>
