<?php
session_start();
require_once "../config.php";

// Periksa apakah user sudah login dan role-nya admin
if (!isset($_SESSION['username']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    echo "<script>alert('Silakan login sebagai admin'); window.location='../guest.php';</script>";
    exit;
}

// Ambil data ringkasan
$santri_query = mysqli_query($conn, "SELECT COUNT(*) as total_santri FROM santri");
$santri = mysqli_fetch_assoc($santri_query);

$guru_query = mysqli_query($conn, "SELECT COUNT(*) as total_guru FROM guru");
$guru = mysqli_fetch_assoc($guru_query);

$mapel_query = mysqli_query($conn, "SELECT COUNT(*) as total_mapel FROM matapelajaran");
$mapel = mysqli_fetch_assoc($mapel_query);

$tanggal_hari_ini = date('Y-m-d');
$absensi_total_query = mysqli_query($conn, "SELECT COUNT(*) as total_absen FROM absensi WHERE tanggal = '$tanggal_hari_ini'");
$absensi_total = mysqli_fetch_assoc($absensi_total_query);

require_once "template/header.php";
require_once "template/side-bar.php";
require_once "template/navbar.php";
?>

<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4 text-primary fw-bold">Dashboard Admin</h1>
            <p class="text-muted fst-italic mb-2">
                <?= date('l, d F Y') ?> | <span id="clock" class="fw-bold text-dark"></span>
            </p>

            <!-- Quote Islami -->
            <div class="alert alert-light shadow-sm border-start border-4 border-primary">
                <i class="fas fa-quote-left me-2 text-primary"></i>
                <em>“Sesungguhnya Allah menyukai orang-orang yang bertakwa dan orang-orang yang berbuat kebaikan.”</em>
                <span class="d-block text-end mt-2">— QS. Ali Imran: 134</span>
            </div>

            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item active">Selamat datang di panel admin Ponpes Inayatullah</li>
            </ol>

            <div class="row g-4">
                <div class="col-xl-3 col-md-6">
                    <div class="card border-0 shadow-lg bg-info text-white">
                        <div class="card-body fs-5 fw-semibold">
                            Jumlah Santri
                            <h2 class="fw-bold mt-2"><?= $santri['total_santri'] ?></h2>
                        </div>
                        <div class="card-footer d-flex align-items-center justify-content-between bg-transparent border-top-0">
                            <a class="text-white stretched-link" href="data_santri.php">Lihat Detail</a>
                            <i class="fas fa-users text-white"></i>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card border-0 shadow-lg bg-secondary text-white">
                        <div class="card-body fs-5 fw-semibold">
                            Jumlah Guru
                            <h2 class="fw-bold mt-2"><?= $guru['total_guru'] ?></h2>
                        </div>
                        <div class="card-footer d-flex align-items-center justify-content-between bg-transparent border-top-0">
                            <a class="text-white stretched-link" href="data_guru.php">Lihat Detail</a>
                            <i class="fas fa-chalkboard-teacher text-white"></i>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card border-0 shadow-lg bg-success text-white">
                        <div class="card-body fs-5 fw-semibold">
                            Mata Pelajaran
                            <h2 class="fw-bold mt-2"><?= $mapel['total_mapel'] ?></h2>
                        </div>
                        <div class="card-footer d-flex align-items-center justify-content-between bg-transparent border-top-0">
                            <a class="text-white stretched-link" href="data_mapel.php">Lihat Detail</a>
                            <i class="fas fa-book-open text-white"></i>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card border-0 shadow-lg bg-warning text-dark">
                        <div class="card-body fs-5 fw-semibold">
                            Absensi Hari Ini
                            <h2 class="fw-bold mt-2"><?= $absensi_total['total_absen'] ?></h2>
                        </div>
                        <div class="card-footer d-flex align-items-center justify-content-between bg-transparent border-top-0">
                            <span class="text-dark">Tanggal: <?= date('d-m-Y') ?></span>
                            <i class="fas fa-calendar-check text-dark"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quote Harian Otomatis -->
            <?php
            $quotes = [
                "Ilmu tanpa amal bagaikan pohon tanpa buah.",
                "Waktu adalah pedang. Jika tidak kau manfaatkan, ia akan memotongmu.",
                "Barangsiapa bersungguh-sungguh, maka ia akan berhasil.",
                "Orang berilmu tidak akan pernah merasa cukup dengan ilmunya.",
                "Sebaik-baik manusia adalah yang paling bermanfaat bagi orang lain."
            ];
            $quote_harian = $quotes[array_rand($quotes)];
            ?>
            <div class="alert alert-info shadow-sm mt-4">
                <i class="fas fa-lightbulb me-2"></i>
                <strong>Quote Hari Ini:</strong> <?= $quote_harian ?>
            </div>

            <!-- Grafik Perkembangan Data -->
            <?php
            $bulan = ["Jan", "Feb", "Mar", "Apr", "Mei", "Jun"];
            $data_santri = [50, 55, 60, 70, 75, $santri['total_santri']];
            $data_guru = [10, 11, 12, 13, 14, $guru['total_guru']];
            $data_absen = [30, 35, 40, 42, 45, $absensi_total['total_absen']];
            ?>
            <div class="card mt-4 mb-4">
                <div class="card-header bg-success text-white fw-bold">
                    <i class="fas fa-chart-line me-2"></i>Grafik Perkembangan Data
                </div>
                <div class="card-body">
                    <canvas id="grafikPerkembangan"></canvas>
                </div>
            </div>
        </div>
    </main>
</div>

<!-- Script Jam Real-time -->
<script>
function updateClock() {
    const now = new Date();
    const jam = now.getHours().toString().padStart(2, '0');
    const menit = now.getMinutes().toString().padStart(2, '0');
    const detik = now.getSeconds().toString().padStart(2, '0');
    document.getElementById('clock').textContent = `${jam}:${menit}:${detik}`;
}
setInterval(updateClock, 1000);
updateClock();
</script>

<!-- Script Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const ctx = document.getElementById('grafikPerkembangan').getContext('2d');
new Chart(ctx, {
    type: 'line',
    data: {
        labels: <?= json_encode($bulan) ?>,
        datasets: [
            {
                label: 'Santri',
                data: <?= json_encode($data_santri) ?>,
                borderColor: 'rgba(54, 162, 235, 1)',
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                tension: 0.4,
                fill: true
            },
            {
                label: 'Guru',
                data: <?= json_encode($data_guru) ?>,
                borderColor: 'rgba(255, 206, 86, 1)',
                backgroundColor: 'rgba(255, 206, 86, 0.2)',
                tension: 0.4,
                fill: true
            },
            {
                label: 'Absensi Hari Ini',
                data: <?= json_encode($data_absen) ?>,
                borderColor: 'rgba(75, 192, 192, 1)',
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                tension: 0.4,
                fill: true
            }
        ]
    },
    options: {
        responsive: true,
        plugins: {
            title: {
                display: false
            }
        },
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});
</script>