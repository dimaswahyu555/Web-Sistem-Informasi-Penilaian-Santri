<?php
session_start();
require_once "../config.php";

// Cek login dan role santri
if (!isset($_SESSION['id_santri']) || $_SESSION['role'] !== 'santri') {
    echo "<script>alert('Silakan login terlebih dahulu sebagai santri.'); window.location.href='../guest.php';</script>";
    exit;
}

$id_santri = $_SESSION['id_santri'];

// Ambil data santri
$q = mysqli_query($conn, "SELECT * FROM santri WHERE id_santri = '$id_santri'");
$data = mysqli_fetch_assoc($q);
if (!$data) {
    echo "<div class='alert alert-danger text-center'>Data santri tidak ditemukan.</div>";
    exit;
}

// Foto
$foto = $data['foto'] ?: 'default.png';
$lokasiFoto = "../image/$foto";
if (!file_exists($lokasiFoto) || empty($data['foto'])) {
    $lokasiFoto = "../image/default-user.png";
}

// Template
require_once "template/header.php";
require_once "template/navbar.php";
require_once "template/side-bar.php";
?>

<style>
    .profile-img {
        width: 150px;
        height: 150px;
        object-fit: cover;
        border-radius: 50%;
        border: 2px solid #ddd;
    }
</style>

<div id="layoutSidenav_content">
    <main class="container-fluid px-4 mt-4">
        <div class="card shadow rounded-4">
            <div class="card-header bg-success text-white">
                <h4 class="mb-0">👤 Profil Santri</h4>
            </div>
            <div class="card-body row">
                <div class="col-md-4 text-center">
                    <img src="<?= $lokasiFoto ?>" alt="Foto Profil" class="profile-img mb-3" id="previewFoto">
                    <h5><?= htmlspecialchars($data['nama_santri']) ?></h5>
                    <p><?= htmlspecialchars($data['program_pendidikan']) ?></p>

                    <input type="file" id="uploadFoto" class="form-control form-control-sm" accept="image/*">
                    <div id="statusUpload" class="mt-2 text-success small"></div>
                </div>
                <div class="col-md-8">
                    <table class="table table-borderless">
                        <tr><th>NISN</th><td>: <?= htmlspecialchars($data['nisn']) ?></td></tr>
                        <tr><th>Jenis Kelamin</th><td>: <?= htmlspecialchars($data['jenis_kelamin']) ?></td></tr>
                        <tr><th>Tanggal Lahir</th><td>: <?= htmlspecialchars($data['tanggal_lahir']) ?></td></tr>
                        <tr><th>Alamat</th><td>: <?= nl2br(htmlspecialchars($data['alamat'])) ?></td></tr>
                        <tr><th>No Telepon Wali</th><td>: <?= htmlspecialchars($data['no_telepon_wali']) ?></td></tr>
                        <tr><th>Nama Wali</th><td>: <?= htmlspecialchars($data['nama_wali_santri']) ?></td></tr>
                        <tr><th>Kelas</th><td>: <?= htmlspecialchars($data['kelas']) ?></td></tr>
                        <tr><th>Tanggal Daftar</th><td>: <?= htmlspecialchars($data['tanggal_daftar']) ?></td></tr>
                    </table>
                </div>
            </div>
        </div>
    </main>
</div>

<script>
document.getElementById("uploadFoto").addEventListener("change", function() {
    const file = this.files[0];
    if (!file) return;

    // Tampilkan preview
    const reader = new FileReader();
    reader.onload = function(e) {
        document.getElementById("previewFoto").src = e.target.result;
    };
    reader.readAsDataURL(file);

    // Kirim ke server
    const formData = new FormData();
    formData.append("foto", file);

    fetch("update_foto.php", {
        method: "POST",
        body: formData
    })
    .then(res => res.text())
    .then(result => {
        document.getElementById("statusUpload").textContent = result;
    })
    .catch(err => {
        document.getElementById("statusUpload").textContent = "Gagal upload foto.";
    });
});
</script>

