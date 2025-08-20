<body class="sb-nav-fixed" style="padding-top: 40px;">
<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once "../config.php";

if (!isset($_SESSION['id_santri']) || $_SESSION['role'] !== 'santri') {
    echo "<script>alert('Silakan login sebagai santri terlebih dahulu'); window.location.href='../login.php';</script>";
    exit;
}

$id_santri = $_SESSION['id_santri'];

// Ambil data santri dan users dari database (realtime update)
$query = mysqli_query($conn, "SELECT users.username, santri.nama_santri, santri.nisn, santri.alamat, santri.jenis_kelamin, santri.program_pendidikan, santri.foto 
                              FROM users 
                              JOIN santri ON users.id_santri = santri.id_santri 
                              WHERE santri.id_santri = '$id_santri'") or die(mysqli_error($conn));

$profile = mysqli_fetch_assoc($query);

// Default foto jika belum upload
$foto = $main_url . "/image/default.png";
if (!empty($profile['foto']) && file_exists("../image/" . $profile['foto'])) {
    // Tambahkan timestamp agar browser tidak pakai cache
    $foto = $main_url . "/image/" . $profile['foto'] . "?v=" . filemtime("../image/" . $profile['foto']);
}
?>

<!-- Navbar -->
<nav class="sb-topnav navbar navbar-expand navbar-dark custom-navbar">
    <!-- Brand -->
    <a class="navbar-brand ps-3" href="<?= $main_url ?>santri/index.php">Ponpes Inayatullah</a>

    <!-- Spacer kanan -->
    <div class="ms-auto d-flex align-items-center">
        <!-- Nama dan Foto Profil -->
        <span class="text-white me-2 text-capitalize"><?= htmlspecialchars($profile['nama_santri']) ?></span>
        <img src="<?= $foto ?>" alt="Foto Profil" width="35" height="35"
             class="rounded-circle border border-light" style="object-fit: cover;">
    </div>
</nav>

<!-- Custom Navbar Style -->
<style>
    .custom-navbar {
        background-color: rgb(164, 167, 88) !important;
    }
</style>
