<?php
session_start();
require_once "../config.php";

// Periksa apakah user sudah login dan role-nya admin
if (!isset($_SESSION['username']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    echo "<script>alert('Silakan login sebagai admin'); window.location='../guest.php';</script>";
    exit;
}

require_once "template/header.php";
require_once "template/side-bar.php";
require_once "template/navbar.php";

$success = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $role = $_POST['role'];
    $id_relasi = $_POST['id_relasi'] ?? null;
    $status = $_POST['status'];

    $password_default = '12345';
    $hashed = password_hash($password_default, PASSWORD_DEFAULT);

    if ($username && $role && $status) {
        $id_admin = $role === 'admin' ? $id_relasi : 'NULL';
        $id_guru = $role === 'guru' ? $id_relasi : 'NULL';
        $id_santri = $role === 'santri' ? $id_relasi : 'NULL';

        $query = "INSERT INTO users (username, password, role, id_admin, id_guru, id_santri, status)
                  VALUES ('$username', '$hashed', '$role', $id_admin, $id_guru, $id_santri, '$status')";

        if (mysqli_query($conn, $query)) {
            $success = "Pengguna berhasil ditambahkan. Password default: <strong>12345</strong>";
        } else {
            $error = "Gagal menambahkan pengguna: " . mysqli_error($conn);
        }
    } else {
        $error = "Harap lengkapi semua isian.";
    }
}
?>

<!-- Mulai dari Main Layout -->
<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">Tambah Pengguna</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item"><a href="<?= $main_url ?>/admin/index.php">Dashboard</a></li>
                <li class="breadcrumb-item active">Tambah Pengguna</li>
            </ol>

            <div class="card mb-4 shadow">
                <div class="card-header">
                    <i class="fas fa-user-plus me-1"></i>
                    Form Tambah Pengguna
                </div>
                <div class="card-body">
                    <?php if ($success): ?>
                        <div class="alert alert-success"><?= $success ?></div>
                    <?php elseif ($error): ?>
                        <div class="alert alert-danger"><?= $error ?></div>
                    <?php endif; ?>

                    <form method="post">
                        <div class="mb-3">
                            <label for="username" class="form-label">Username*</label>
                            <input type="text" class="form-control" name="username" required>
                        </div>

                        <div class="mb-3">
                            <label for="role" class="form-label">Role*</label>
                            <select name="role" class="form-select" onchange="toggleRelasiField(this.value)" required>
                                <option value="">-- Pilih --</option>
                                <option value="admin">Admin</option>
                                <option value="guru">Guru</option>
                                <option value="santri">Santri</option>
                            </select>
                        </div>

                        <div class="mb-3" id="relasiField" style="display: none;">
                            <label for="id_relasi" class="form-label">ID Relasi (Admin/Guru/Santri)</label>
                            <input type="number" class="form-control" name="id_relasi">
                        </div>

                        <div class="mb-3">
                            <label for="status" class="form-label">Status*</label>
                            <select name="status" class="form-select" required>
                                <option value="Aktif">Aktif</option>
                                <option value="Tidak Aktif">Tidak Aktif</option>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-success w-100">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </main>


<script>
    function toggleRelasiField(role) {
        const field = document.getElementById('relasiField');
        if (role === 'admin' || role === 'guru' || role === 'santri') {
            field.style.display = 'block';
        } else {
            field.style.display = 'none';
        }
    }
</script>
