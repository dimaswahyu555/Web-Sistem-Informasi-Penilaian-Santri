<?php
session_start();
require_once "../config.php";

if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'guru') {
    echo "<script>alert('Silakan login sebagai guru'); window.location='../guest.php';</script>";
    exit;
}

require_once "./template_guru/header.php";
require_once "./template_guru/navbar.php";
require_once "./template_guru/side-bar.php";

// Ambil daftar kelas untuk dropdown filter
$kelas_result = mysqli_query($conn, "SELECT DISTINCT kelas FROM santri ORDER BY kelas ASC");
$selected_kelas = $_GET['kelas'] ?? '';

// Ambil data santri berdasarkan kelas jika dipilih
$santri_query = "SELECT id_santri, nama_santri, nisn, jenis_kelamin, alamat, no_telepon_wali FROM santri";
if (!empty($selected_kelas)) {
    $santri_query .= " WHERE kelas = '" . mysqli_real_escape_string($conn, $selected_kelas) . "'";
}
$santri_result = mysqli_query($conn, $santri_query);

// Ambil daftar mata pelajaran aktif
$mapel_result = mysqli_query($conn, "SELECT id_matapelajaran, nama_matapelajaran FROM matapelajaran WHERE status_aktif = 'Aktif'");
?>

<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4">

            <!-- ALERT NOTIFIKASI -->
            <?php if (isset($_GET['msg'])): ?>
                <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
                    <?= htmlspecialchars($_GET['msg']) ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <h1 class="mt-4">Absensi Santri</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item"><a href="<?= $main_url ?>/guru/index.php">Home</a></li>
                <li class="breadcrumb-item active">Absensi Harian</li>
            </ol>

            <!-- Filter Kelas -->
            <form method="GET" class="mb-4">
                <label for="kelas" class="form-label">Pilih Kelas</label>
                <select name="kelas" id="kelas" class="form-select w-25 d-inline-block" onchange="this.form.submit()">
                    <option value="">-- Semua Kelas --</option>
                    <?php while ($kls = mysqli_fetch_assoc($kelas_result)) : ?>
                        <option value="<?= $kls['kelas'] ?>" <?= $selected_kelas == $kls['kelas'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($kls['kelas']) ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </form>

            <!-- Form Absensi -->
            <form action="user/proses_absensi.php" method="POST">
                <div class="card shadow-lg rounded-4">
                    <div class="card-body">

                        <p class="text-muted"><strong>Keterangan:</strong> A = Alpa, I = Izin, S = Sakit, M = Masuk</p>

                        <!-- Mata Pelajaran -->
                        <div class="mb-3">
                            <label for="id_matapelajaran" class="form-label">Pilih Mata Pelajaran</label>
                            <select name="id_matapelajaran" id="id_matapelajaran" class="form-select w-50" required onchange="updateMapelText(this)">
                                <option value="" disabled selected>-- Pilih Mata Pelajaran --</option>
                                <?php while ($mapel = mysqli_fetch_assoc($mapel_result)) : ?>
                                    <option value="<?= $mapel['id_matapelajaran'] ?>" data-nama="<?= htmlspecialchars($mapel['nama_matapelajaran']) ?>">
                                        <?= htmlspecialchars($mapel['nama_matapelajaran']) ?>
                                    </option>
                                <?php endwhile; ?>
                            </select>
                            <input type="hidden" name="mapel" id="mapel_text">
                        </div>

                        <!-- Tanggal Absensi -->
                        <div class="mt-4 mb-4">
                            <label for="tanggal" class="form-label">Tanggal Absensi</label>
                            <?php $today = date('Y-m-d'); ?>
                            <input type="date" name="tanggal" id="tanggal" class="form-control w-25" required value="<?= $today ?>" min="<?= $today ?>">
                        </div>

                        <!-- Jam Pelajaran -->
                        <div class="mb-4">
                            <label for="jam_ke" class="form-label">Jam Pelajaran Ke-</label>
                            <select name="jam_ke" id="jam_ke" class="form-select w-25" required>
                                <option value="" disabled selected>-- Pilih Jam --</option>
                                <?php for ($i = 1; $i <= 10; $i++): ?>
                                    <option value="<?= $i ?>">Jam ke-<?= $i ?></option>
                                <?php endfor; ?>
                            </select>
                        </div>

                        <!-- Tabel Santri -->
                        <div class="table-responsive">
                            <table class="table table-bordered align-middle table-hover">
                                <thead class="text-center">
                                    <tr>
                                        <th>NIS</th>
                                        <th>Nama</th>
                                        <th>Jenis Kelamin</th>
                                        <th>Alamat</th>
                                        <th>Kehadiran</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (mysqli_num_rows($santri_result) > 0): ?>
                                        <?php
                                        $opsi = ['Hadir' => 'M', 'Izin' => 'I', 'Sakit' => 'S', 'Alpa' => 'A'];
                                        while ($row = mysqli_fetch_assoc($santri_result)) :
                                            $id_santri = $row['id_santri'];
                                        ?>
                                            <tr>
                                                <td><?= htmlspecialchars($row['nisn']) ?></td>
                                                <td><?= htmlspecialchars($row['nama_santri']) ?></td>
                                                <td><?= htmlspecialchars($row['jenis_kelamin']) ?></td>
                                                <td><?= htmlspecialchars($row['alamat']) ?></td>
                                                <td class="text-center">
                                                    <?php foreach ($opsi as $label => $short): ?>
                                                        <label class="me-2">
                                                            <input type="radio" name="absensi[<?= $id_santri ?>]" value="<?= $label ?>" required> <?= $short ?>
                                                        </label>
                                                    <?php endforeach; ?>
                                                </td>
                                            </tr>
                                        <?php endwhile; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="5" class="text-center text-danger">Tidak ada santri pada kelas ini.</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>

                        <input type="hidden" name="kelas" value="<?= htmlspecialchars($selected_kelas) ?>">

                        <button type="submit" class="btn btn-primary mt-3">Simpan Absensi</button>
                    </div>
                </div>
            </form>
        </div>
    </main>
</div>

<script>
function updateMapelText(selectObj) {
    const nama = selectObj.options[selectObj.selectedIndex].getAttribute('data-nama');
    document.getElementById('mapel_text').value = nama;
}
</script>
