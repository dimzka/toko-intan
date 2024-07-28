<?php
include('petugas/config/config.php');

$db = dbConnect();

if (isset($_POST["TblRegister"])) {
    // Collect and sanitize form data
    $nama = $db->escape_string($_POST["nama"]);
    $email = $db->escape_string($_POST["email"]);
    $password = $_POST["password"];
    $alamat = $db->escape_string($_POST["alamat"]);
    $no_telp = $db->escape_string($_POST["no_telp"]);

    // Hash the password
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

    // Check if email already exists
    $stmt = $db->prepare("SELECT * FROM pelanggan WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $res = $stmt->get_result();

    if ($res->num_rows > 0) {
        // Email already exists
        header("Location: register.php?error=1");
        exit();
    } else {
        // Insert new user
        $stmt = $db->prepare("INSERT INTO pelanggan (nama, email, password, alamat, no_telp) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $nama, $email, $hashedPassword, $alamat, $no_telp);
        if ($stmt->execute()) {
            // Registration successful
            echo "<script type='text/javascript'>
            alert('Registration successful');
            window.location='login.php';
          </script>";
        } else {
            // Query failed
            echo "<script type='text/javascript'>
                    alert('Database error');
                    window.location='register.php';
                  </script>";
        }
        exit();
    }
} else {
    // No form submission
    echo "<script type='text/javascript'>
                alert('Please fill out the form.');
                window.location='register.php';
              </script>";
    exit();
}
?>
