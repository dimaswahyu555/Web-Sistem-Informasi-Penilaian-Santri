<?php
// Mulai session dan cek role guru
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'guru') {
    header("Location: ../guest.php");
    exit;
}

require_once "../config.php";

// Ambil ID guru dari sesi
$id_guru = $_SESSION['id_guru'];

// Ambil nilai filter dari query string (jika ada)
$selected_santri = $_GET['santri'] ?? '';
$selected_kelas = $_GET['kelas'] ?? '';

// Ambil data santri yang pernah tercatat di absensi guru ini
$query_santri = mysqli_query($conn, "
    SELECT DISTINCT s.id_santri, s.nama_santri 
    FROM absensi a
    JOIN santri s ON a.id_santri = s.id_santri
    WHERE a.id_matapelajaran IN (
        SELECT id_matapelajaran FROM jadwal_pelajaran WHERE id_guru = '$id_guru'
    )
");

// Ambil data kelas yang pernah tercatat di absensi guru ini
$query_kelas = mysqli_query($conn, "
    SELECT DISTINCT s.kelas 
    FROM absensi a
    JOIN santri s ON a.id_santri = s.id_santri
    WHERE a.id_matapelajaran IN (
        SELECT id_matapelajaran FROM jadwal_pelajaran WHERE id_guru = '$id_guru'
    )
");

// Query utama untuk ambil data absensi
$absensi_query = "
    SELECT a.*, s.nama_santri, s.nisn, s.kelas, mp.nama_matapelajaran 
    FROM absensi a
    JOIN santri s ON a.id_santri = s.id_santri
    JOIN matapelajaran mp ON a.id_matapelajaran = mp.id_matapelajaran
    WHERE a.id_matapelajaran IN (
        SELECT id_matapelajaran FROM jadwal_pelajaran WHERE id_guru = '$id_guru'
    )
";

// Tambahkan filter jika ada
if (!empty($selected_santri)) {
    $absensi_query .= " AND s.id_santri = '" . mysqli_real_escape_string($conn, $selected_santri) . "'";
}
if (!empty($selected_kelas)) {
    $absensi_query .= " AND s.kelas = '" . mysqli_real_escape_string($conn, $selected_kelas) . "'";
}

$absensi_query .= " ORDER BY a.tanggal DESC";

$absensi_result = mysqli_query($conn, $absensi_query);

// Template layout
require_once "./template_guru/header.php";
require_once "./template_guru/navbar.php";
require_once "./template_guru/side-bar.php";
?>

<div id="layoutSidenav_content">
<main>
    <div class="container-fluid px-4">
        <h1 class="mt-4">Data Absensi</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
            <li class="breadcrumb-item active">Absensi Santri</li>
        </ol>

        <!-- Form filter nama santri & kelas -->
        <form method="GET" class="row g-3 mb-4">
            <div class="col-md-4">
                <label class="form-label">Nama Santri</label>
                <select name="santri" class="form-select">
                    <option value="">-- Semua Santri --</option>
                    <?php while ($row = mysqli_fetch_assoc($query_santri)) : ?>
                        <option value="<?= $row['id_santri'] ?>" <?= $selected_santri == $row['id_santri'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($row['nama_santri']) ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label">Kelas</label>
                <select name="kelas" class="form-select">
                    <option value="">-- Semua Kelas --</option>
                    <?php while ($row = mysqli_fetch_assoc($query_kelas)) : ?>
                        <option value="<?= $row['kelas'] ?>" <?= $selected_kelas == $row['kelas'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($row['kelas']) ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div class="col-md-4 align-self-end">
                <button type="submit" class="btn btn-primary">Filter</button>
            </div>
        </form>

        <!-- Tabel absensi -->
        <div class="card shadow rounded-4">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover text-center">
                        <thead class="table-light">
                            <tr>
                                <th>Tanggal</th>
                                <th>NISN</th>
                                <th>Nama Santri</th>
                                <th>Kelas</th>
                                <th>Mata Pelajaran</th>
                                <th>Status Kehadiran</th>
                                <th>Jam Ke</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (mysqli_num_rows($absensi_result) > 0): ?>
                                <?php while ($row = mysqli_fetch_assoc($absensi_result)): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($row['tanggal']) ?></td>
                                        <td><?= htmlspecialchars($row['nisn']) ?></td>
                                        <td><?= htmlspecialchars($row['nama_santri']) ?></td>
                                        <td><?= htmlspecialchars($row['kelas']) ?></td>
                                        <td><?= htmlspecialchars($row['nama_matapelajaran']) ?></td>
                                        <td><?= htmlspecialchars($row['status_kehadiran']) ?></td>
                                        <td><?= htmlspecialchars($row['jam_ke'] ?? '-') ?></td>
                                    </tr>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="8" class="text-danger">Tidak ada data absensi ditemukan.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</main>
</div>
