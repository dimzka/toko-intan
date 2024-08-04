<?php

include 'petugas/config/config.php';

// Start session to access user data
session_start();

// Connect to the database
$db = dbConnect();
if (!$db) {
    die("Database connection failed: " . $db->connect_error);
}

// Fetch categories for the navbar
$query = "SELECT * FROM kategori";
$result = $db->query($query);
if (!$result) {
    die("Query Error: " . $db->error);
}
$categories = $result->fetch_all(MYSQLI_ASSOC);

// Fetch products
$query = "SELECT * FROM produk";
$result = $db->query($query);
if (!$result) {
    die("Query Error: " . $db->error);
}
$products = $result->fetch_all(MYSQLI_ASSOC);

// Fetch cart items if user is logged in
$cartItems = [];
$cartItemCount = 0;
if (isset($_SESSION['id_pelanggan'])) {
    $id_pelanggan = $_SESSION['id_pelanggan'];

    // Fetch cart and cart items
    $query = "SELECT p.id_produk, p.nama, p.harga, p.gambar, ci.jumlah
              FROM cart c
              JOIN cart_item ci ON c.id_cart = ci.id_cart
              JOIN produk p ON ci.id_produk = p.id_produk
              WHERE c.id_pelanggan = ?";
    $stmt = $db->prepare($query);
    $stmt->bind_param('i', $id_pelanggan);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $cartItems = $result->fetch_all(MYSQLI_ASSOC);
        $cartItemCount = array_sum(array_column($cartItems, 'jumlah'));
    }
}

// Close database connection
$db->close();
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Belanja online dengan penawaran terbaik di produk elektronik, pakaian, dan kesehatan. Diskon hingga 80%!">
    <title>Online Shop</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick-theme.min.css">
    <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="assets/sweetalert/sweetalert2.min.css">

    <!-- SweetAlert2 JS -->
    <script src="assets/sweetalert/sweetalert2.all.min.js"></script>
    <style>
        /* Custom styles here */
        .carousel {
            background-color: black;
            color: white;
        }

        .card-img-top {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }

        .card {
            background-color: transparent;
            color: white;
            border: 1px solid #444;
        }

        .card .btn-light {
            color: #000;
            background-color: transparent;
            border: 1px solid #000;
        }

        .product-carousel .card {
            margin: 10px;
        }

        .slick-slide {
            margin: 0 10px;
        }

        .slick-dots {
            bottom: 10px;
        }

        .card-title,
        .card-text {
            color: black;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <?php if (isset($_SESSION['message'])) : ?>
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        icon: '<?= htmlspecialchars($_SESSION['message_type']) === 'success' ? 'success' : 'error' ?>',
                        title: '<?= htmlspecialchars($_SESSION['message_type']) === 'success' ? 'Sukses' : 'Gagal' ?>',
                        text: '<?= htmlspecialchars($_SESSION['message']) ?>',
                        timer: 3000,
                        timerProgressBar: true,
                        showConfirmButton: false,
                        showCloseButton: true,
                        closeButtonAriaLabel: 'Tutup notifikasi'
                    });
                });
            </script>
            <?php
            // Hapus pesan setelah ditampilkan
            unset($_SESSION['message']);
            unset($_SESSION['message_type']);
            ?>
        <?php endif; ?>
        <a class="navbar-brand" href="#">Online Shop</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="dropdown ml-3">
            <a class="dropdown-toggle" href="#" id="cartDropdown" data-toggle="dropdown" aria-expanded="true">
                <i class="fa fa-shopping-cart"></i>
                <span>Your Cart</span>
                <div class="badge qty" id="cartItemCount"><?php echo htmlspecialchars($cartItemCount); ?></div>
            </a>
            <div class="dropdown-menu cart-dropdown" id="cartDropdownMenu">
                <a class="dropdown-item" href="checkout.php">Checkout</a>
            </div>
        </div>
        <div class="ml-auto">
            <?php if (isset($_SESSION['id_pelanggan'])) : ?>
                <a class="navbar-text" href="riwayat.php">Lihat Transaksi</a>
                <span class="navbar-text mr-3">
                    Hi, <?php echo htmlspecialchars($_SESSION['nama']); ?>
                </span>
                <a href="logout.php" class="btn btn-outline-danger">Logout</a>
            <?php else : ?>
                <a href="login.php" class="btn btn-outline-primary">Login</a>
            <?php endif; ?>
        </div>
    </nav>