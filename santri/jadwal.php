<?php
session_start();
require_once "../config.php";

// Cek login
if (!isset($_SESSION['id_santri']) || $_SESSION['role'] !== 'santri') {
    echo "<script>alert('Silakan login sebagai santri terlebih dahulu'); window.location.href='../guest.php';</script>";
    exit;
}

$id_santri   = $_SESSION['id_santri'];
$nama_santri = $_SESSION['nama_santri'] ?? 'Santri';

// Ambil nama kelas dari tabel santri
$q_kelas = mysqli_query($conn, "SELECT kelas FROM santri WHERE id_santri = '$id_santri'");
$d_kelas = mysqli_fetch_assoc($q_kelas);
$kelas_santri = $d_kelas['kelas'] ?? null;

if (!$kelas_santri) {
    echo "<div class='alert alert-danger'>Kelas tidak ditemukan untuk santri ini.</div>";
    exit;
}

// Template layout
require_once "template/header.php";
require_once "template/navbar.php";
require_once "template/side-bar.php";
?>

<style>
    body {
        background-color: #f8f9fa;
    }
    table th, table td {
        vertical-align: middle;
    }
</style>

<!-- Konten utama -->
<div id="layoutSidenav_content">
    <main class="container-fluid px-4 mt-4">
        <h3 class="mb-4">📅 Jadwal Pelajaran Saya</h3>
        <p><strong>Santri:</strong> <?= htmlspecialchars($nama_santri) ?> <br>
           <strong>Kelas:</strong> <?= htmlspecialchars($kelas_santri) ?></p>

        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead class="table-success">
                    <tr>
                        <th>Hari</th>
                        <th>Jam</th>
                        <th>Mata Pelajaran</th>
                        <th>Ruangan</th>
                        <th>Semester</th>
                        <th>Tahun Ajaran</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $q = mysqli_query($conn, "SELECT * FROM jadwal_pelajaran 
                        WHERE kelas = '$kelas_santri' 
                        ORDER BY FIELD(hari, 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'), jam_pelajaran");

                    if (mysqli_num_rows($q) > 0) {
                        while ($row = mysqli_fetch_assoc($q)) {
                            $id_mapel = $row['id_matapelajaran'];

                            // Ambil nama mapel
                            $mapel = '-';
                            $mq = mysqli_query($conn, "SELECT nama_matapelajaran FROM matapelajaran WHERE id_matapelajaran = '$id_mapel'");
                            if ($mq && mysqli_num_rows($mq)) {
                                $dm = mysqli_fetch_assoc($mq);
                                $mapel = $dm['nama_matapelajaran'];
                            }

                            echo "<tr>
                                <td>" . htmlspecialchars($row['hari']) . "</td>
                                <td>" . htmlspecialchars($row['jam_pelajaran']) . "</td>
                                <td>" . htmlspecialchars($mapel) . "</td>
                                <td>" . htmlspecialchars($row['ruangan']) . "</td>
                                <td>" . htmlspecialchars($row['semester']) . "</td>
                                <td>" . htmlspecialchars($row['tahun_ajaran']) . "</td>
                            </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='6' class='text-center'>Tidak ada jadwal tersedia</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </main>
</div>

