<?php
// Atur waktu hidup session jadi 1 jam (opsional)
ini_set('session.gc_maxlifetime', 3600);
session_set_cookie_params(3600);

session_start();
require_once "config.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    if (empty($username) || empty($password)) {
        $_SESSION['login_error'] = "Username dan password wajib diisi.";
        header("Location: login.php");
        exit;
    }

    // Ambil data user dari tabel users
    $stmt = mysqli_prepare($conn, "SELECT * FROM users WHERE username = ?");
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($user = mysqli_fetch_assoc($result)) {
        // Verifikasi password
        if (password_verify($password, $user['password'])) {
            // Cek status akun aktif
            if ($user['status'] === 'Aktif') {
                // Simpan informasi user ke dalam session
                $_SESSION['user_id'] = $user['id_user'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['role'] = $user['role'];

                // Simpan ID tambahan berdasarkan role
                if ($user['role'] === 'santri') {
                    $_SESSION['id_santri'] = $user['id_santri'];
                } elseif ($user['role'] === 'guru') {
                    $_SESSION['id_guru'] = $user['id_guru'];
                } elseif ($user['role'] === 'admin') {
                    $_SESSION['id_admin'] = $user['id_admin'];
                }

                // Proteksi tambahan: IP dan User Agent
                $_SESSION['ip'] = $_SERVER['REMOTE_ADDR'];
                $_SESSION['user_agent'] = $_SERVER['HTTP_USER_AGENT'];

                // Redirect berdasarkan role
                switch ($user['role']) {
                    case 'admin':
                        header("Location: admin/index.php");
                        break;
                    case 'guru':
                        header("Location: guru/index.php");
                        break;
                    case 'santri':
                        header("Location: santri/index.php");
                        break;
                    default:
                        $_SESSION['login_error'] = "Peran tidak dikenali.";
                        header("Location: login.php");
                        break;
                }
                exit;
            } else {
                $_SESSION['login_error'] = "Akun Anda tidak aktif.";
            }
        } else {
            $_SESSION['login_error'] = "Password salah.";
        }
    } else {
        $_SESSION['login_error'] = "Username tidak ditemukan.";
    }

    // Kembali ke halaman login jika gagal
    header("Location: login.php");
    exit;
} else {
    header("Location: login.php");
    exit;
}
