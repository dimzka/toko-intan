<?php

// Upload a file
$target_dir = "uploads/";
$target_file = $target_dir . basename($_FILES["bukti"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

if (move_uploaded_file($_FILES["bukti"]["tmp_name"], 'uploads/'.$_FILES["bukti"]["name"])) {
    echo "The file ". basename( $_FILES["bukti"]["name"]). " has been uploaded.";
} else {
    echo "Sorry, there was an error uploading your file.";
}

// Get filename
$filename = $_FILES["bukti"]["name"];

// Save into the database
include 'petugas/config/config.php';

// Connect to the database
$db = dbConnect();

// Insert into database
$query = "INSERT INTO bukti (id_transaksi, status, file) VALUES (null, 0, ?)";

$statement = $db->prepare($query);
$statement->bind_param("s", $filename);
$statement->execute();
$statement->close();
$db->close();

// Redirect to checkout
header("Location: checkout.php");
exit();