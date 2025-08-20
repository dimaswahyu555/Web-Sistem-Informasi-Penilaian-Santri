<?php
// Mulai session jika belum ada
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Cek apakah sudah login sebagai santri
if (!isset($_SESSION['id_santri']) || $_SESSION['role'] !== 'santri') {
    echo "<script>alert('Silakan login sebagai santri terlebih dahulu'); window.location.href='../guest.php';</script>";
    exit;
}

require_once "../config.php";

$id_santri = $_SESSION['id_santri'];

// Ambil jumlah nilai
$queryNilai = mysqli_query($conn, "SELECT COUNT(*) AS total_nilai FROM nilai WHERE id_santri = '$id_santri'");
$dataNilai = mysqli_fetch_assoc($queryNilai);

// Cek absensi hari ini
$tanggalHariIni = date('Y-m-d');
$queryAbsensi = mysqli_query($conn, "SELECT * FROM absensi WHERE id_santri = '$id_santri' AND tanggal = '$tanggalHariIni'");
$statusAbsensi = (mysqli_num_rows($queryAbsensi) > 0) ? "Hadir" : "Belum Absen";

// Ambil tanggal dan hari dalam format lokal
$hari = date("l");
$namaHari = [
    'Sunday' => 'Minggu',
    'Monday' => 'Senin',
    'Tuesday' => 'Selasa',
    'Wednesday' => 'Rabu',
    'Thursday' => 'Kamis',
    'Friday' => 'Jumat',
    'Saturday' => 'Sabtu'
];
$tanggalLengkap = $namaHari[$hari] . ', ' . date('d F Y');

// Include layout/template
require_once "template/header.php";
require_once "template/navbar.php";
require_once "template/side-bar.php";
?>

<!-- Main Content -->
<div id="layoutSidenav_content">
    <main>
        <div class="container px-4">
            <h1 class="mt-4 text-success fw-bold">Dashboard Santri</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item active">Selamat datang di panel santri Ponpes Inayatullah</li>
            </ol>

            <!-- Tanggal dan Jam -->
            <div class="row g-4 mb-4">
                <div class="col-md-6">
                    <div class="card shadow border-0 bg-light">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <div>
                                <h5 class="mb-0 fw-bold"><i class="fas fa-calendar-alt me-2 text-primary"></i><?= $tanggalLengkap ?></h5>
                                <small class="text-muted">Tanggal hari ini</small>
                            </div>
                            <div>
                                <h4 id="jamSekarang" class="mb-0 text-primary fw-bold"></h4>
                                <small class="text-muted">Jam sekarang</small>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Motivasi -->
                <div class="col-md-6">
                    <div class="card shadow border-0 bg-white">
                        <div class="card-body">
                            <h6 class="fw-bold"><i class="fas fa-lightbulb me-2 text-warning"></i>Motivasi Hari Ini</h6>
                            <blockquote class="blockquote mb-0 fst-italic text-muted">
                                “Barangsiapa menempuh jalan untuk mencari ilmu, maka Allah akan mudahkan baginya jalan ke surga.” 
                                <footer class="blockquote-footer mt-1">HR. Muslim</footer>
                            </blockquote>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Statistik -->
            <div class="row g-4">
                <!-- Total Nilai -->
                <div class="col-xl-6 col-md-6">
                    <div class="card border-0 shadow-lg bg-primary text-white">
                        <div class="card-body fs-5 fw-semibold">
                            Total Nilai Saya
                            <h2 class="fw-bold mt-2"><?= $dataNilai['total_nilai'] ?></h2>
                        </div>
                        <div class="card-footer d-flex justify-content-between bg-transparent border-top-0">
                            <a class="text-white stretched-link" href="nilai_saya.php">Lihat Detail</a>
                            <i class="fas fa-star text-white"></i>
                        </div>
                    </div>
                </div>

                <!-- Kehadiran -->
                <div class="col-xl-6 col-md-6">
                    <div class="card border-0 shadow-lg bg-warning text-dark">
                        <div class="card-body fs-5 fw-semibold">
                            Kehadiran Hari Ini
                            <h2 class="fw-bold mt-2"><?= $statusAbsensi ?></h2>
                        </div>
                        <div class="card-footer d-flex justify-content-between bg-transparent border-top-0">
                            <a class="text-dark stretched-link" href="absensi_saya.php">Lihat Riwayat</a>
                            <i class="fas fa-calendar-check text-dark"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Informasi Tambahan -->
            <div class="card mt-4 shadow-sm">
                <div class="card-header bg-success text-white">
                    <i class="fas fa-info-circle me-2"></i> Informasi Tambahan
                </div>
                <div class="card-body">
                    <p class="text-muted mb-0">
                        Gunakan menu di samping untuk melihat nilai, jadwal pelajaran, serta riwayat absensi Anda. Terus semangat belajar dan raih prestasi!
                    </p>
                </div>
            </div>
        </div>
    </main>
</div>

<!-- Live Clock -->
<script>
    function updateClock() {
        const now = new Date();
        const jam = now.getHours().toString().padStart(2, '0');
        const menit = now.getMinutes().toString().padStart(2, '0');
        const detik = now.getSeconds().toString().padStart(2, '0');
        document.getElementById("jamSekarang").textContent = `${jam}:${menit}:${detik}`;
    }
    setInterval(updateClock, 1000);
    updateClock();
</script>

<?php require_once "template/footer.php"; ?>
