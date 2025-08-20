<?php
session_start();

// Kosongkan semua variabel session
$_SESSION = [];

// Hapus semua variabel session
session_unset();

// Hancurkan session di server
session_destroy();

// Hapus cookie session (opsional tapi aman)
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(
        session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Redirect ke halaman guest atau login
header("Location: guest.php");
exit;
?>
