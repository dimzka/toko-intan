<?php
include('config.php');

$db = dbConnect();

if (isset($_POST["TblLogin"])) {
    $username = $db->escape_string($_POST["username"]);
    $password = $_POST["password"]; // Do not escape the password here since it needs to be verified with password_verify later

    $sql = "SELECT * FROM pengguna WHERE username='$username'";
    $res = $db->query($sql);

    if ($res) {
        if ($res->num_rows == 1) {
            $data = $res->fetch_assoc();

            // Verify the password
            if ($password == $data['password']) { // Pastikan di sini password tidak dienkripsi
                session_start();
                $_SESSION["Id_pengguna"] = $data["id_pengguna"];
                $_SESSION["nama"] = $data["nama"];
                $_SESSION["username"] = $data["username"];
                $_SESSION["jabatan"] = $data["jabatan"];

                header("Location: ../index.php");
            } else {
                header("Location: ../login.php?error=1"); // Incorrect password
                exit();
            }
        } else {
            header("Location: ../login.php?error=2"); // Username not found
            exit();
        }
    } else {
        header("Location: ../login.php?error=3"); // Query failed
        exit();
    }
} else {
    header("Location: ../login.php?error=5"); // No form submission
    exit();
}
?>
