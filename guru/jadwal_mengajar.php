<?php
session_start();
require_once "../config.php";

// Cek apakah guru sudah login
if (!isset($_SESSION['id_guru'])) {
    header("Location: ../guest.php");
    exit;
}

$id_guru = $_SESSION['id_guru'];

// Ambil data jadwal
$query = "
    SELECT jp.*, mp.nama_matapelajaran
    FROM jadwal_pelajaran jp
    JOIN matapelajaran mp ON jp.id_matapelajaran = mp.id_matapelajaran
    WHERE jp.id_guru = '$id_guru'
    ORDER BY FIELD(jp.hari, 'Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu'), jp.jam_pelajaran
";
$result = mysqli_query($conn, $query);

require_once "../guru/template_guru/header.php";
require_once "../guru/template_guru/navbar.php";
require_once "../guru/template_guru/side-bar.php";
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Jadwal Mengajar</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: #f8f9fa;
        }

        .main-content {
            margin-left: 260px; /* Sesuaikan dengan lebar sidebar */
            padding: 60px 30px 30px;
        }

        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
            background: #ffffff;
        }

        .table-responsive {
            overflow-x: auto;
        }

        .table {
            width: 100%;
            min-width: 1100px; /* Agar tabel lebih lebar */
        }

        .table th {
            background-color: #20c997;
            color: white;
            text-align: center;
            vertical-align: middle;
        }

        .table td {
            text-align: center;
            vertical-align: middle;
            white-space: nowrap;
            padding: 12px;
        }

        h3 {
            font-weight: 600;
            color: #343a40;
        }

        .fade-in {
            animation: fadeIn 0.6s ease-in-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body>
    <div class="main-content fade-in container-fluid">
        <h3 class="mb-4">📅 Jadwal Mengajar Saya</h3>

        <div class="card p-4">
            <div class="table-responsive">
                <table class="table table-hover table-bordered align-middle">
                    <thead>
                        <tr>
                            <th style="min-width: 50px;">No</th>
                            <th style="min-width: 100px;">Hari</th>
                            <th style="min-width: 120px;">Jam</th>
                            <th style="min-width: 200px;">Mata Pelajaran</th>
                            <th style="min-width: 120px;">Kelas</th>
                            <th style="min-width: 130px;">Ruangan</th>
                            <th style="min-width: 120px;">Semester</th>
                            <th style="min-width: 150px;">Tahun Ajaran</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (mysqli_num_rows($result) > 0): ?>
                            <?php $no = 1; while ($row = mysqli_fetch_assoc($result)): ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= $row['hari'] ?></td>
                                    <td><?= $row['jam_pelajaran'] ?></td>
                                    <td><?= $row['nama_matapelajaran'] ?></td>
                                    <td><?= $row['kelas'] ?></td>
                                    <td><?= $row['ruangan'] ?></td>
                                    <td><?= $row['semester'] ?></td>
                                    <td><?= $row['tahun_ajaran'] ?></td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="8" class="text-center text-muted">Belum ada jadwal yang ditetapkan.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>

