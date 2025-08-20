<?php
session_start();
require_once "../config.php";

if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'guru') {
    echo "<script>alert('Silakan login sebagai guru'); window.location='../guest.php';</script>";
    exit;
}

require_once "../guru/template_guru/header.php";
require_once "../guru/template_guru/navbar.php";
require_once "../guru/template_guru/side-bar.php";

// Ambil data
$santri = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total_santri FROM santri"));
$guru = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total_guru FROM guru"));
$nilai = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total_nilai FROM nilai"));

$tanggal_hari_ini = date('Y-m-d');
$absensi_total = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS total_absen FROM absensi WHERE tanggal = '$tanggal_hari_ini'"));
$jumlah_santri = max(1, intval($santri['total_santri']));
$persentase_absensi = number_format(($absensi_total['total_absen'] / $jumlah_santri) * 100, 2);

// Ambil 5 santri terbaru
$santri_terbaru = mysqli_query($conn, "SELECT * FROM santri ORDER BY id_santri DESC LIMIT 5");
?>

<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4 text-primary fw-bold">Dashboard Guru</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item active">Selamat datang di panel guru Ponpes Inayatullah</li>
            </ol>

            <!-- Jam & Quotes -->
            <div class="row g-3 mb-4">
                <div class="col-md-8">
                    <div class="card shadow-sm">
                        <div class="card-body d-flex align-items-center">
                            <div>
                                <h5 id="tanggal" class="mb-1 fw-bold text-primary"></h5>
                                <h3 id="jam" class="mb-0 text-dark fw-bold"></h3>
                            </div>
                            <div class="ms-auto">
                                <i class="fas fa-clock fa-3x text-primary"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card shadow-sm bg-light">
                        <div class="card-body text-center">
                            <blockquote class="blockquote mb-0">
                                <p class="mb-2 fst-italic">"Ilmu tanpa amal adalah sia-sia, amal tanpa ilmu adalah kesesatan."</p>
                                <footer class="blockquote-footer">Imam Al-Ghazali</footer>
                            </blockquote>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Info Hari Ini -->
            <div class="alert alert-info shadow-sm">
                <i class="fas fa-info-circle me-2"></i> Hari ini tanggal <?= date('d-m-Y') ?> | Absensi: <?= $absensi_total['total_absen'] ?> santri
            </div>

            <!-- Ringkasan -->
            <div class="row g-4 mb-4">
                <div class="col-xl-3 col-md-6">
                    <div class="card border-0 shadow-sm bg-info text-white">
                        <div class="card-body">Jumlah Santri <h3><?= $santri['total_santri'] ?></h3></div>
                        <div class="card-footer d-flex justify-content-between">
                            <a href="data_santri.php" class="text-white stretched-link">Detail</a>
                            <i class="fas fa-users"></i>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card border-0 shadow-sm bg-success text-white">
                        <div class="card-body">Jumlah Guru <h3><?= $guru['total_guru'] ?></h3></div>
                        <div class="card-footer d-flex justify-content-between">
                            <span class="text-white">-</span>
                            <i class="fas fa-chalkboard-teacher"></i>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card border-0 shadow-sm bg-secondary text-white">
                        <div class="card-body">Jumlah Nilai <h3><?= $nilai['total_nilai'] ?></h3></div>
                        <div class="card-footer d-flex justify-content-between">
                            <a href="data_nilai.php" class="text-white stretched-link">Detail</a>
                            <i class="fas fa-star"></i>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card border-0 shadow-sm bg-warning text-dark">
                        <div class="card-body">Absensi Hari Ini <h3><?= $persentase_absensi ?>%</h3></div>
                        <div class="card-footer d-flex justify-content-between">
                            <a href="tambah_absensi.php" class="text-dark stretched-link">Isi/Lihat</a>
                            <i class="fas fa-calendar-check"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Grafik Absensi -->
            <div class="card mb-4 shadow-sm">
                <div class="card-header bg-primary text-white">
                    <i class="fas fa-chart-line me-2"></i> Grafik Kehadiran Minggu Ini
                </div>
                <div class="card-body">
                    <canvas id="absensiChart"></canvas>
                </div>
            </div>

            <!-- Tabel Santri Terbaru -->
            <div class="card mb-5 shadow-sm">
                <div class="card-header bg-success text-white">
                    <i class="fas fa-user-clock me-2"></i> Santri Terbaru
                </div>
                <div class="card-body table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>NISN</th>
                                <th>Nama Santri</th>
                                <th>Kelas</th>
                                <th>Jenis Kelamin</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = mysqli_fetch_assoc($santri_terbaru)) : ?>
                                <tr>
                                    <td><?= $row['nisn'] ?></td>
                                    <td><?= $row['nama_santri'] ?></td>
                                    <td><?= $row['kelas'] ?></td>
                                    <td><?= $row['jenis_kelamin'] ?></td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </main>
</div>

<!-- Script Jam -->
<script>
function updateTime() {
    const now = new Date();
    const jam = now.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit', second: '2-digit' });
    const hari = now.toLocaleDateString('id-ID', { weekday: 'long', day: 'numeric', month: 'long', year: 'numeric' });
    document.getElementById('jam').textContent = jam;
    document.getElementById('tanggal').textContent = hari;
}
setInterval(updateTime, 1000);
updateTime();
</script>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const ctx = document.getElementById('absensiChart').getContext('2d');
const absensiChart = new Chart(ctx, {
    type: 'line',
    data: {
        labels: ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'],
        datasets: [{
            label: 'Persentase Kehadiran',
            data: [80, 85, 90, 87, <?= $persentase_absensi ?>],
            borderColor: 'rgba(54, 162, 235, 1)',
            backgroundColor: 'rgba(54, 162, 235, 0.3)',
            fill: true,
            tension: 0.4
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: { position: 'top' }
        }
    }
});
</script>
