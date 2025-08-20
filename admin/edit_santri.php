<?php 
session_start();
require_once "../config.php";

// Periksa apakah user sudah login dan role-nya admin
if (!isset($_SESSION['username']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    echo "<script>alert('Silakan login sebagai admin'); window.location='../guest.php';</script>";
    exit;
}

// Periksa apakah parameter id ada, dengan validasi nilai yang aman
$id_santri = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id_santri > 0) {
    // Ambil data santri berdasarkan id_santri
    $query = "SELECT * FROM santri WHERE id_santri = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id_santri);
    $stmt->execute();
    $result = $stmt->get_result();
    $data_santri = $result->fetch_assoc();

    // Jika data tidak ditemukan, arahkan kembali ke halaman data_santri.php
    if (!$data_santri) {
        header("Location: http://localhost/ppinayatullah2/admin/data_santri.php");
        exit;
    }
} else {
    header("Location: http://localhost/ppinayatullah2/admin/data_santri.php");
    exit;
}

// Inisialisasi nilai form untuk menghindari undefined array key
$nama_santri = $data_santri['nama_santri'] ?? '';
$kelas = $data_santri['kelas'] ?? '';
$nisn = $data_santri['nisn'] ?? '';
$jenis_kelamin = $data_santri['jenis_kelamin'] ?? 'Laki-laki';  // Default 'Laki-laki'
$status_siswa = $data_santri['status_santri'] ?? 'Aktif';  // Default 'Aktif'

// Proses jika tombol "Simpan Perubahan" ditekan
if (isset($_POST['update'])) {
    $nama_santri = $_POST['nama_santri'] ?? '';
    $kelas = $_POST['kelas'] ?? '';
    $nisn = $_POST['nisn'] ?? '';
    $jenis_kelamin = $_POST['jenis_kelamin'] ?? '';
    $status_siswa = $_POST['status_santri'] ?? '';

    // Update data santri
    $update_query = "UPDATE santri SET nama_santri = ?, kelas = ?, nisn = ?, jenis_kelamin = ?, status_santri = ? WHERE id_santri = ?";
    $stmt_update = $conn->prepare($update_query);
    $stmt_update->bind_param("sssssi", $nama_santri, $kelas, $nisn, $jenis_kelamin, $status_siswa, $id_santri);

    if ($stmt_update->execute()) {
        echo "<script>alert('Data berhasil diperbarui!'); window.location.href = 'http://localhost/ppinayatullah2/admin/edit_santri.php?id=$id_santri';</script>";
    } else {
        echo "<script>alert('Data gagal diperbarui!');</script>";
    }
}

require_once "template/header.php";
require_once "template/navbar.php";
require_once "template/side-bar.php";
?>
<!-- Main Content -->
<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">Edit Data Santri</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item"><a href="<?= $main_url ?>/admin/index.php">Home</a></li>
                <li class="breadcrumb-item"><a href="/ppinayatullah2/admin/data_santri.php">Data Santri</a></li>
                <li class="breadcrumb-item active">Edit Data Santri</li>
            </ol>

            <div class="card shadow-lg rounded-4">
                <div class="card-header bg-dark text-white">
                    <i class="fas fa-edit"></i> Form Edit Data Santri
                </div>
                <div class="card-body p-4">
                    <form action="" method="post">
                        <div class="mb-3">
                            <label for="nama_santri" class="form-label">Nama Santri</label>
                            <input type="text" class="form-control" id="nama_santri" name="nama_santri"
                                   value="<?= htmlspecialchars($nama_santri, ENT_QUOTES, 'UTF-8'); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="kelas" class="form-label">Kelas</label>
                            <input type="text" class="form-control" id="kelas" name="kelas"
                                   value="<?= htmlspecialchars($kelas, ENT_QUOTES, 'UTF-8'); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="nisn" class="form-label">NISN</label>
                            <input type="text" class="form-control" id="nisn" name="nisn"
                                   value="<?= htmlspecialchars($nisn, ENT_QUOTES, 'UTF-8'); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                            <select name="jenis_kelamin" id="jenis_kelamin" class="form-control" required>
                                <option value="Laki-laki" <?= $jenis_kelamin == 'Laki-laki' ? 'selected' : ''; ?>>Laki-laki</option>
                                <option value="Perempuan" <?= $jenis_kelamin == 'Perempuan' ? 'selected' : ''; ?>>Perempuan</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="status_siswa" class="form-label">Status Siswa</label>
                            <select name="status_santri" id="status_santri" class="form-control" required>
                                <option value="Aktif" <?= $status_siswa == 'Aktif' ? 'selected' : ''; ?>>Aktif</option>
                                <option value="Tidak Aktif" <?= $status_siswa == 'Tidak Aktif' ? 'selected' : ''; ?>>Tidak Aktif</option>
                            </select>
                        </div>

                        <button type="submit" name="update" class="btn btn-success">Simpan Perubahan</button>
                        <a href="/ppinayatullah2/admin/data_santri.php" class="btn btn-secondary">Kembali</a>
                    </form>
                </div>
            </div>
        </div>
    </main>
</div>
