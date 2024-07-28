<?php
session_start();
include 'petugas/config/config.php';

// Connect to the database
$db = dbConnect();
if (!$db) {
    die("Database connection failed: " . $db->connect_error);
}

if (!isset($_SESSION['id_pelanggan'])) {
    echo "0";
    exit();
}

$id_pelanggan = $_SESSION['id_pelanggan'];

// Fetch cart items count
$query = "SELECT COUNT(*) as count
          FROM cart c
          JOIN cart_item ci ON c.id_cart = ci.id_cart
          WHERE c.id_pelanggan = ?";
$stmt = $db->prepare($query);
$stmt->bind_param('i', $id_pelanggan);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

echo $row['count'];

$db->close();
?>
