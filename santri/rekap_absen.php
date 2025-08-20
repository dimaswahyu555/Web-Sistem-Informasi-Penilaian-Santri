<?php
session_start();
require_once "../config.php";

// Cek apakah pengguna sudah login sebagai santri
if (!isset($_SESSION['id_santri']) || $_SESSION['role'] !== 'santri') {
    echo "<script>alert('Silakan login sebagai santri terlebih dahulu'); window.location.href='../guest.php';</script>";
    exit;
}

$id_santri = $_SESSION['id_santri'];

// Ambil data absensi berdasarkan santri
$query = "
    SELECT 
        mp.nama_matapelajaran AS mapel,
        a.tanggal,
        a.status_kehadiran
    FROM absensi a
    JOIN matapelajaran mp ON a.id_matapelajaran = mp.id_matapelajaran
    WHERE a.id_santri = '$id_santri'
    ORDER BY mp.nama_matapelajaran, a.tanggal
";

$result = mysqli_query($conn, $query);

// Kelompokkan data absensi per mapel dan tanggal
$rekap = [];
$tanggalList = [];

while ($row = mysqli_fetch_assoc($result)) {
    $mapel = $row['mapel'];
    $tanggal = $row['tanggal'];

    if (!in_array($tanggal, $tanggalList)) {
        $tanggalList[] = $tanggal;
    }

    if (!isset($rekap[$mapel])) {
        $rekap[$mapel] = ['kehadiran' => []];
    }

    $rekap[$mapel]['kehadiran'][$tanggal] = $row['status_kehadiran'];
}

sort($tanggalList);

// Include komponen layout
require_once "template/header.php";
require_once "template/navbar.php";
require_once "template/side-bar.php";
?>

<style>
    .table-wrapper {
        overflow-x: auto;
        background-color: white;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 0 8px rgba(0, 0, 0, 0.1);
    }

    table th,
    table td {
        white-space: nowrap;
    }

    .sticky-col {
        position: sticky;
        left: 0;
        background: white;
        z-index: 2;
    }

    .sticky-col-2 {
        position: sticky;
        left: 60px;
        background: white;
        z-index: 2;
    }
</style>

<div id="layoutSidenav_content">
    <main class="container-fluid px-4 mt-4">
        <h4 class="mb-4">📋 Rekap Absensi Santri</h4>

        <div class="table-wrapper">
            <table class="table table-bordered text-center">
                <thead class="table-light">
                    <tr>
                        <th class="sticky-col">No</th>
                        <th class="sticky-col-2">Mata Pelajaran</th>
                        <?php foreach ($tanggalList as $tgl): ?>
                            <th><?= date('d-m-Y', strtotime($tgl)) ?></th>
                        <?php endforeach; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    foreach ($rekap as $mapel => $data):
                    ?>
                        <tr>
                            <td class="sticky-col"><?= $no++ ?></td>
                            <td class="sticky-col-2"><?= htmlspecialchars($mapel) ?></td>
                            <?php foreach ($tanggalList as $tgl): ?>
                                <td>
                                    <?php
                                    $status = $data['kehadiran'][$tgl] ?? '';
                                    switch ($status) {
                                        case 'Hadir':
                                            echo "<span class='text-success'><i class='fa-solid fa-check'></i></span>";
                                            break;
                                        case 'Izin':
                                            echo "<span class='text-warning'>I</span>";
                                            break;
                                        case 'Sakit':
                                            echo "<span class='text-info'>S</span>";
                                            break;
                                        case 'Alpa':
                                            echo "<span class='text-danger'>A</span>";
                                            break;
                                        default:
                                            echo "-";
                                    }
                                    ?>
                                </td>
                            <?php endforeach; ?>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </main>
</div>

<?php require_once "template/footer.php"; ?>
