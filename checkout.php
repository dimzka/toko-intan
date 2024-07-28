<?php
session_start();
include 'petugas/config/config.php';

// Connect to the database
$db = dbConnect();
if (!$db) {
    die("Database connection failed: " . $db->connect_error);
}

if (isset($_SESSION['id_pelanggan'])) {
    $id_pelanggan = $_SESSION['id_pelanggan'];
    $total = 0;

    // Begin transaction
    $db->begin_transaction();

    try {
        // Create new transaction
        $query = "INSERT INTO transaksi (id_pelanggan, tanggal, total, status) VALUES (?, NOW(), 0, 'Pending')";
        $stmt = $db->prepare($query);
        $stmt->bind_param('i', $id_pelanggan);
        $stmt->execute();
        $id_transaksi = $stmt->insert_id;

        // Get cart items
        $query = "SELECT ci.id_produk, ci.jumlah, p.harga
                  FROM cart c
                  JOIN cart_item ci ON c.id_cart = ci.id_cart
                  JOIN produk p ON ci.id_produk = p.id_produk
                  WHERE c.id_pelanggan = ?";
        $stmt = $db->prepare($query);
        $stmt->bind_param('i', $id_pelanggan);
        $stmt->execute();
        $result = $stmt->get_result();

        while ($row = $result->fetch_assoc()) {
            // Insert into detail_transaksi
            $query = "INSERT INTO detail_transaksi (id_transaksi, id_produk, jumlah, harga) VALUES (?, ?, ?, ?)";
            $stmt = $db->prepare($query);
            $stmt->bind_param('iiid', $id_transaksi, $row['id_produk'], $row['jumlah'], $row['harga']);
            $stmt->execute();

            // Update stock
            $query = "UPDATE produk SET stok = stok - ? WHERE id_produk = ?";
            $stmt = $db->prepare($query);
            $stmt->bind_param('ii', $row['jumlah'], $row['id_produk']);
            $stmt->execute();

            // Update total transaksi
            $total += $row['jumlah'] * $row['harga'];
        }

        // Update total transaksi
        $query = "UPDATE transaksi SET total = ? WHERE id_transaksi = ?";
        $stmt = $db->prepare($query);
        $stmt->bind_param('di', $total, $id_transaksi);
        $stmt->execute();

        // Delete cart items
        $query = "DELETE ci.*, c.*
                  FROM cart c
                  JOIN cart_item ci ON c.id_cart = ci.id_cart
                  WHERE c.id_pelanggan = ?";
        $stmt = $db->prepare($query);
        $stmt->bind_param('i', $id_pelanggan);
        $stmt->execute();

        // Commit transaction
        $db->commit();

        // Redirect to a confirmation or home page
        header('Location: confirmation.php?status=success');
        exit();
    } catch (Exception $e) {
        // Rollback transaction
        $db->rollback();
        error_log("Checkout failed: " . $e->getMessage()); // Log the error for debugging
        echo "Checkout failed. Please try again.";
    }

    $db->close();
} else {
    echo "You need to log in to checkout.";
}
?>
