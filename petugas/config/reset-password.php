<?php
include('config.php');

$db = dbConnect();

if (isset($_POST["TblUpdate"])) {
    $password = $_POST["password"];
    $token = $_POST["token"];

    // Validate token
    $stmt = $db->prepare("SELECT * FROM password_resets WHERE token = ? AND created_at > (NOW() - INTERVAL 1 HOUR)");
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $res = $stmt->get_result();

    if ($res->num_rows == 1) {
        // Token is valid
        $reset = $res->fetch_assoc();
        $email = $reset["email"];
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        // Update the password
        $stmt = $db->prepare("UPDATE pengguna SET password = ? WHERE email = ?");
        $stmt->bind_param("ss", $hashedPassword, $email);
        if ($stmt->execute()) {
            // Delete the token
            $stmt = $db->prepare("DELETE FROM password_resets WHERE token = ?");
            $stmt->bind_param("s", $token);
            $stmt->execute();

            header("Location: ../login.php?success=1"); // Password updated
        } else {
            header("Location: ../reset-password.php?error=1"); // Update failed
        }
    } else {
        header("Location: ../reset-password.php?error=2"); // Invalid or expired token
    }
    exit();
} else {
    header("Location: ../reset-password.php?error=3"); // No form submission
    exit();
}
?>
