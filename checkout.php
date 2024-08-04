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
        $query = "SELECT ci.id_produk, ci.jumlah, p.harga, discount
                  FROM cart c
                  JOIN cart_item ci ON c.id_cart = ci.id_cart
                  JOIN produk p ON ci.id_produk = p.id_produk
                  WHERE c.id_pelanggan = ?";
        $stmt = $db->prepare($query);
        $stmt->bind_param('i', $id_pelanggan);
        $stmt->execute();
        $result = $stmt->get_result();

        while ($row = $result->fetch_assoc()) {
            // Check harga discount
            if($row['discount'] > 0) {
                $row['harga'] = $row['harga'] - ($row['harga'] * 0.1);
            }

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

        // Get transaction id
        $query = "SELECT id_transaksi FROM transaksi WHERE id_pelanggan = ? ORDER BY id_transaksi DESC LIMIT 1";
        $stmt = $db->prepare($query);
        $stmt->bind_param('i', $id_pelanggan);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $id_transaksi = $row['id_transaksi'];

        // Update latest bukti
        $query = "UPDATE bukti SET id_transaksi = ? WHERE id_transaksi IS NULL";
        $stmt = $db->prepare($query);
        $stmt->bind_param('i', $id_transaksi);
        $stmt->execute();

        // Commit transaction
        $db->commit();
    } catch (Exception $e) {
        // Rollback transaction
        $db->rollback();
        error_log("Checkout failed: " . $e->getMessage()); // Log the error for debugging
        echo "Checkout failed. Please try again.";
    }

    // Check if total transaction last month > 5.000.000
    $query = "SELECT sum(total) as total FROM transaksi 
        WHERE MONTH(tanggal) = MONTH(DATE_SUB(NOW(), INTERVAL 1 MONTH))
        AND YEAR(tanggal) = YEAR(NOW())
        AND id_pelanggan = ?";

    $stmt = $db->prepare($query);
    $stmt->bind_param('i', $id_pelanggan);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $totalLastMonth = $row['total'];
    
    // Check if total transaction last month > 5.000.000
    if($totalLastMonth > 5000000) {
        include 'apriori.php';

        $query = "
            SELECT detail_transaksi.* 
            FROM transaksi 
            RIGHT JOIN detail_transaksi ON transaksi.id_transaksi = detail_transaksi.id_transaksi 
            JOIN produk ON detail_transaksi.id_produk = produk.id_produk 
            JOIN kategori ON produk.id_kategori = kategori.id_kategori
            WHERE transaksi.id_pelanggan = ?
            AND MONTH(transaksi.tanggal) = MONTH(DATE_SUB(NOW(), INTERVAL 1 MONTH))
            AND YEAR(transaksi.tanggal) = YEAR(NOW())
            GROUP BY detail_transaksi.id_transaksi, detail_transaksi.id_produk
            ORDER BY detail_transaksi.id_transaksi
            LIMIT 500
        ";

        $stmt = $db->prepare($query);
        $stmt->bind_param('i', $id_pelanggan);
        $stmt->execute();
        $results = $stmt->get_result();

        $dataset = [];

        // Grupping data    
        while ($row = $results->fetch_assoc()) {
            if(!isset($dataset[$row['id_transaksi']])) {
                $dataset[$row['id_transaksi']] = [];
            }
            array_push($dataset[$row['id_transaksi']], $row['id_produk']);
        }

        $dataset = array_values($dataset);
        $minSupport = 2;
        $minConfidence = 0.6;

        $apriori = apriori($dataset, 2);

        // Get cart items data
        $query = "SELECT ci.id_cart, ci.id_produk, ci.jumlah, p.harga
                FROM cart c
                JOIN cart_item ci ON c.id_cart = ci.id_cart
                JOIN produk p ON ci.id_produk = p.id_produk
                WHERE c.id_pelanggan = ?";
        $stmt = $db->prepare($query);
        $stmt->bind_param('i', $id_pelanggan);
        $stmt->execute();
        $result = $stmt->get_result();
        $cartItems = [];

        while ($row = $result->fetch_assoc()) {
            $cartItems[] = $row['id_produk'];
        }

        $cartItems = implode(' ', $cartItems);

        // Get recomendation base on cart item
        $recomendation = [];
        foreach($apriori as $key => $aps) {
            if(str_contains($key, $cartItems)) {
                $recomendation[] = $key;
            }
        } 

        // Save recomendation to database
        foreach($recomendation as $value) {
            $item = str_replace($cartItems, '', $value);
            $item = trim($item);

            if($item) {
                $item = explode(' ', $item);
                foreach($item as $value) {
                    // Check the product is already recomended today
                    $query = "SELECT * FROM rekomendasi_produk 
                        WHERE id_pelanggan = ? AND id_produk = ? 
                        AND DAY(tanggal_rekomendasi) = DAY(NOW())
                        AND MONTH(tanggal_rekomendasi) = MONTH(NOW()) 
                        AND YEAR(tanggal_rekomendasi) = YEAR(NOW())";
                    $stmt = $db->prepare($query);
                    $stmt->bind_param('ii', $id_pelanggan, $value);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    if ($result->num_rows > 0) {
                        continue;
                    } else {
                        if($value != '') {
                            $sql = "INSERT INTO rekomendasi_produk (id_pelanggan, id_produk, tanggal_rekomendasi) VALUES (?, ?, now())";
                            $stmt = $db->prepare($sql);
                            $stmt->bind_param('ii', $id_pelanggan, $value);
                            $stmt->execute();
                        }
                    }
                }
            }
        }

        // Delete cart items
        $query = "DELETE ci.*, c.*
        FROM cart c
        JOIN cart_item ci ON c.id_cart = ci.id_cart
        WHERE c.id_pelanggan = ?";
        $stmt = $db->prepare($query);
        $stmt->bind_param('i', $id_pelanggan);
        $stmt->execute();
    }

    $db->close();
} else {
    echo "You need to log in to checkout.";
}
?>

<script type="text/javascript">
    alert('Data berhasil ditambahkan!');
    window.location = 'index.php';
</script>