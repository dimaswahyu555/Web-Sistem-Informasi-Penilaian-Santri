<?php
session_start();
require_once "../config.php";

// Validasi login
if (!isset($_SESSION['username']) || !isset($_SESSION['role'])) {
    echo "<script>alert('Silakan login terlebih dahulu'); window.location='../guest.php';</script>";
    exit;
}

$username = $_SESSION['username'];
$role     = $_SESSION['role'];
$msg      = $_GET['msg'] ?? '';

// Include template sesuai role
switch ($role) {
    case 'admin':
        require_once "template/header.php";
        require_once "template/navbar.php";
        require_once "template/side-bar.php";
        break;
    case 'guru':
        require_once "../guru/template_guru/header.php";
        require_once "../guru/template_guru/navbar.php";
        require_once "../guru/template_guru/side-bar.php";
        break;
    case 'santri':
        require_once "../santri/template/header.php";
        require_once "../santri/template/navbar.php";
        require_once "../santri/template/side-bar.php";
        break;
    default:
        echo "<script>alert('Role tidak dikenali!'); window.location='../login.php';</script>";
        exit;
}
?>

<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">Ganti Password</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item active">Ganti Password</li>
            </ol>

            <?php if ($msg): ?>
                <div class="alert alert-info"><?= htmlspecialchars($msg) ?></div>
            <?php endif; ?>

            <form action="proses_password.php" method="post">
                <div class="card shadow rounded">
                    <div class="card-header">
                        <span class="h5 my-2"><i class="fa-solid fa-pen-to-square"></i> Ganti Password</span>
                        <button type="submit" name="simpan" class="btn btn-primary float-end"><i class="fa-solid fa-cloud"></i> Simpan</button>
                        <button type="reset" class="btn btn-danger float-end me-2"><i class="fa-solid fa-xmark"></i> Reset</button>
                    </div>
                    <div class="card-body">
                        <input type="hidden" name="username" value="<?= htmlspecialchars($username) ?>">
                        <input type="hidden" name="role" value="<?= htmlspecialchars($role) ?>">

                        <div class="mb-3">
                            <label for="old_password" class="form-label">Password Lama</label>
                            <input type="password" class="form-control" name="old_password" required>
                        </div>

                        <div class="mb-3">
                            <label for="new_password" class="form-label">Password Baru</label>
                            <input type="password" class="form-control" name="new_password" minlength="4" maxlength="20" required>
                        </div>

                        <div class="mb-3">
                            <label for="confirm_password" class="form-label">Konfirmasi Password Baru</label>
                            <input type="password" class="form-control" name="confirm_password" required>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </main>
</div>
