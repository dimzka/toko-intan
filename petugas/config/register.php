<?php
include('config.php');

$db = dbConnect();

if (isset($_POST["TblRegister"])) {
    $nama = $db->escape_string($_POST["nama"]);
    $username = $db->escape_string($_POST["username"]);
    $email = $db->escape_string($_POST["email"]);
    $password = $_POST["password"];
    $jabatan = $db->escape_string($_POST["jabatan"]);

    // Hash the password
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

    // Check if username or email already exists
    $stmt = $db->prepare("SELECT * FROM pengguna WHERE username = ? OR email = ?");
    $stmt->bind_param("ss", $username, $email);
    $stmt->execute();
    $res = $stmt->get_result();

    if ($res->num_rows > 0) {
        header("Location: ../register.php?error=1"); // Username or Email already exists
        exit();
    } else {
        // Insert new user
        $stmt = $db->prepare("INSERT INTO pengguna (nama, username, password, email, jabatan) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $nama, $username, $hashedPassword, $email, $jabatan);
        if ($stmt->execute()) {
            echo "<script type='text/javascript'>
            alert('Berhasil daftar');
            window.location='../login.php';
          </script>";// Registration successful
        } else {
            echo "<script type='text/javascript'>
                    alert('Database error');
                    window.location='../register.php';
                  </script>"; // Query failed
        }
        exit();
    }
} else {
    echo "<script type='text/javascript'>
                    alert('tolong isi yang kosong');
                    window.location='../index.php?page=data-admin';
                  </script>"; // No form submission
    exit();
}
?>
