<?php
include('petugas/config/config.php');

$db = dbConnect();

if (isset($_POST["TblLogin"])) {
    $email = $db->escape_string($_POST["email"]);
    $password = $_POST["password"];

    $sql = "SELECT * FROM pelanggan WHERE email='$email'";
    $res = $db->query($sql);

    if ($res) {
        if ($res->num_rows == 1) {
            $data = $res->fetch_assoc();

            // Check if password matches
            if ($password == $data['password']) {
                session_start();
                $_SESSION["id_pelanggan"] = $data["id_pelanggan"];
                $_SESSION["nama"] = $data["nama"];

                header("Location: index.php");
                exit();
            } else {
                header("Location: login.php?error=1"); // Incorrect password
                exit();
            }
        } else {
            header("Location: login.php?error=2"); // Email not found
            exit();
        }
    } else {
        header("Location: login.php?error=3"); // Query failed
        exit();
    }
} else {
    header("Location: login.php?error=5"); // No form submission
    exit();
}
?>
