<?php
session_start();
include 'petugas/config/config.php';

// Connect to the database
$db = dbConnect();
if (!$db) {
    die("Database connection failed: " . $db->connect_error);
}


// Check if user is logged in
if (!isset($_SESSION['id_pelanggan'])) {
    header("Location: login.php");
    exit();
}

$id_pelanggan = $_SESSION['id_pelanggan'];
$id_produk = $_GET['id_produk'];

// Check if the product is already in the cart
$query = "SELECT id_cart FROM cart WHERE id_pelanggan = ?";
$stmt = $db->prepare($query);
$stmt->bind_param('i', $id_pelanggan);
$stmt->execute();
$result = $stmt->get_result();
$cart = $result->fetch_assoc();

if ($cart) {
    $id_cart = $cart['id_cart'];
} else {
    // Create a new cart
    $query = "INSERT INTO cart (id_pelanggan) VALUES (?)";
    $stmt = $db->prepare($query);
    $stmt->bind_param('i', $id_pelanggan);
    $stmt->execute();
    $id_cart = $stmt->insert_id;
}

// Check if the product is already in the cart
$query = "SELECT id_cart_item FROM cart_item WHERE id_cart = ? AND id_produk = ?";
$stmt = $db->prepare($query);
$stmt->bind_param('ii', $id_cart, $id_produk);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // Update quantity if product is already in the cart
    $query = "UPDATE cart_item SET jumlah = jumlah + 1 WHERE id_cart = ? AND id_produk = ?";
    $stmt = $db->prepare($query);
    $stmt->bind_param('ii', $id_cart, $id_produk);
    $stmt->execute();
} else {
    // Add new product to the cart
    $query = "INSERT INTO cart_item (id_cart, id_produk, jumlah) VALUES (?, ?, 1)";
    if(isset($_GET['discount'])) {
        $query = "INSERT INTO cart_item (id_cart, id_produk, jumlah, discount) VALUES (?, ?, 1, 1)";
    }

    $stmt = $db->prepare($query);
    $stmt->bind_param('ii', $id_cart, $id_produk);
    $stmt->execute();
}

$stmt->close();
$db->close();

// Redirect to the previous page
header("Location: " . $_SERVER['HTTP_REFERER']);
exit();
?>
