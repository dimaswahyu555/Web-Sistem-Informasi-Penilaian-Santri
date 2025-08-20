<?php
session_start();
require_once "../config.php";

if (isset($_POST['simpan'])) {
    $username         = $_POST['username'];
    $role             = $_POST['role'];
    $old_password     = $_POST['old_password'];
    $new_password     = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    if ($new_password !== $confirm_password) {
        header("Location: ganti_password.php?msg=Konfirmasi password tidak cocok!");
        exit;
    }

    $stmt = $conn->prepare("SELECT password FROM users WHERE username = ? AND role = ?");
    $stmt->bind_param("ss", $username, $role);
    $stmt->execute();
    $stmt->bind_result($hashed_password_db);
    $stmt->fetch();
    $stmt->close();

    if (!password_verify($old_password, $hashed_password_db)) {
        header("Location: ganti_password.php?msg=Password lama salah!");
        exit;
    }

    $hashed_new = password_hash($new_password, PASSWORD_DEFAULT);
    $update = $conn->prepare("UPDATE users SET password = ? WHERE username = ? AND role = ?");
    $update->bind_param("sss", $hashed_new, $username, $role);

    if ($update->execute()) {
        header("Location: ganti_password.php?msg=Password berhasil diperbarui!");
    } else {
        header("Location: ganti_password.php?msg=Gagal memperbarui password!");
    }

    $update->close();
} else {
    header("Location: ganti_password.php");
}
?>