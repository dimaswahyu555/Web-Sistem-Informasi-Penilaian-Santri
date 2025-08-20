<?php
include '../config.php';
session_start();

// Pastikan user login sebagai santri
if (!isset($_SESSION['id_santri']) || $_SESSION['role'] !== 'santri') {
    echo "<script>alert('Silakan login sebagai santri terlebih dahulu'); window.location.href='../guest.php';</script>";
    exit;
}

$id_santri = $_SESSION['id_santri'];
$query = mysqli_query($conn, "SELECT * FROM nilai WHERE id_santri = '$id_santri' ORDER BY tahun_ajaran DESC, semester DESC");

$data_nilai = [];
$total_nilai = 0;
$jumlah_data = 0;

while ($data = mysqli_fetch_assoc($query)) {
    $data_nilai[] = $data;
    if (!is_null($data['nilai_akhir'])) {
        $total_nilai += (float)$data['nilai_akhir'];
        $jumlah_data++;
    }
}

$rata_rata = ($jumlah_data > 0) ? number_format($total_nilai / $jumlah_data, 2) : '-';

// Template
require_once "template/header.php";
require_once "template/navbar.php";
require_once "template/side-bar.php";
?>

<style>
    body {
        background-color: #f8f9fa;
    }

    .card-header h4 {
        font-size: 1.25rem;
    }

    table th, table td {
        vertical-align: middle !important;
    }
</style>

<!-- Konten Utama -->
<div id="layoutSidenav_content">
    <main class="container-fluid px-4 mt-4">
        <div class="card shadow rounded-4">
            <div class="card-header bg-primary text-white py-3 px-4">
                <h4 class="mb-0">📘 Nilai Raport Anda</h4>
            </div>

            <div class="card-body px-4">
                <a href="export_nilai_pdf.php" class="btn btn-danger mb-4" target="_blank">
                    <i class="bi bi-file-earmark-pdf"></i> Download PDF
                </a>

                <div class="table-responsive">
                    <table class="table table-striped table-bordered text-center align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th>No</th>
                                <th>Mata Pelajaran</th>
                                <th>Semester</th>
                                <th>Tahun Ajaran</th>
                                <th>Tugas</th>
                                <th>UTS</th>
                                <th>UAS</th>
                                <th>Hafalan</th>
                                <th>Nilai Akhir</th>
                                <th>Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (count($data_nilai) > 0): ?>
                                <?php $no = 1; ?>
                                <?php foreach ($data_nilai as $nilai): ?>
                                    <tr>
                                        <td><?= $no++; ?></td>
                                        <td><?= htmlspecialchars($nilai['mapel']); ?></td>
                                        <td><?= htmlspecialchars($nilai['semester']); ?></td>
                                        <td><?= htmlspecialchars($nilai['tahun_ajaran']); ?></td>
                                        <td><?= $nilai['nilai_tugas'] ?? '-'; ?></td>
                                        <td><?= $nilai['nilai_uts'] ?? '-'; ?></td>
                                        <td><?= $nilai['nilai_uas'] ?? '-'; ?></td>
                                        <td><?= $nilai['nilai_hafalan'] ?? '-'; ?></td>
                                        <td class="fw-semibold"><?= $nilai['nilai_akhir'] ?? '-'; ?></td>
                                        <td><?= htmlspecialchars($nilai['keterangan'] ?? '-'); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                                <tr class="table-warning fw-bold">
                                    <td colspan="8">Rata-rata Nilai Akhir</td>
                                    <td><?= $rata_rata; ?></td>
                                    <td>-</td>
                                </tr>
                            <?php else: ?>
                                <tr>
                                    <td colspan="10" class="text-center text-muted">Belum ada data nilai.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>
</div>

<?php require_once "template/footer.php"; ?>
