<?php
session_start();
require_once "../config.php";

// Periksa apakah user sudah login dan role-nya admin
if (!isset($_SESSION['username']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    echo "<script>alert('Silakan login sebagai admin'); window.location='../guest.php';</script>";
    exit;
}
require_once "template/header.php";
require_once "template/side-bar.php";
require_once "template/navbar.php";

// Cek apakah form disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $hari            = $_POST['hari'];
    $jam_pelajaran   = $_POST['jam_pelajaran'];
    $id_matapelajaran = $_POST['id_matapelajaran'];
    $id_guru         = $_POST['id_guru'];
    $kelas           = $_POST['kelas'];
    $ruangan         = $_POST['ruangan'];
    $tahun_ajaran    = $_POST['tahun_ajaran'];
    $semester        = $_POST['semester'];

    $stmt = mysqli_prepare($conn, "INSERT INTO jadwal_pelajaran (hari, jam_pelajaran, id_matapelajaran, id_guru, kelas, ruangan, tahun_ajaran, semester) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    mysqli_stmt_bind_param($stmt, "ssiissss", $hari, $jam_pelajaran, $id_matapelajaran, $id_guru, $kelas, $ruangan, $tahun_ajaran, $semester);

    if (mysqli_stmt_execute($stmt)) {
        $status = "success";
    } else {
        $status = "error";
    }
}

// Ambil data mapel
$mapel = mysqli_query($conn, "SELECT * FROM matapelajaran WHERE status_aktif = 1");

// Ambil data guru
$guru = mysqli_query($conn, "SELECT * FROM guru WHERE status_aktif = 1");
?>

<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4"> Tambah Jadwal Pelajaran</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item"><a href="<?= $main_url ?>/admin/index.php">Home</a></li>
                <li class="breadcrumb-item active">Jadwal Pelajaran</li>
            </ol>


            <?php if (isset($status) && $status == "success"): ?>
                <div class="alert alert-success">Jadwal berhasil disimpan.</div>
            <?php elseif (isset($status) && $status == "error"): ?>
                <div class="alert alert-danger">Terjadi kesalahan saat menyimpan jadwal.</div>
            <?php endif; ?>

            <div class="card shadow-sm">
                <div class="card-body">
                    <form method="POST">
                        <div class="mb-3">
                            <label for="hari" class="form-label">Hari</label>
                            <select name="hari" id="hari" class="form-control" required>
                                <option value="">-- Pilih Hari --</option>
                                <option>Senin</option>
                                <option>Selasa</option>
                                <option>Rabu</option>
                                <option>Kamis</option>
                                <option>Jumat</option>
                                <option>Sabtu</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="jam_pelajaran" class="form-label">Jam Pelajaran</label>
                            <input type="text" name="jam_pelajaran" id="jam_pelajaran" class="form-control" placeholder="Contoh: 07.00 - 08.00" required>
                        </div>

                        <div class="mb-3">
                            <label for="id_matapelajaran" class="form-label">Mata Pelajaran</label>
                            <select name="id_matapelajaran" id="id_matapelajaran" class="form-control" required>
                                <option value="">-- Pilih Mata Pelajaran --</option>
                                <?php while($row = mysqli_fetch_assoc($mapel)) { ?>
                                    <option value="<?= $row['id_matapelajaran']; ?>"><?= $row['nama_matapelajaran']; ?></option>
                                <?php } ?>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="id_guru" class="form-label">Guru Pengajar</label>
                            <select name="id_guru" id="id_guru" class="form-control" required>
                                <option value="">-- Pilih Guru --</option>
                                <?php while($rowg = mysqli_fetch_assoc($guru)) { ?>
                                    <option value="<?= $rowg['id_guru']; ?>"><?= $rowg['nama_guru']; ?></option>
                                <?php } ?>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="kelas" class="form-label">Kelas</label>
                            <input type="text" name="kelas" id="kelas" class="form-control" placeholder="Contoh: 7A, 9B, 12 IPA" required>
                        </div>

                        <div class="mb-3">
                            <label for="ruangan" class="form-label">Ruangan</label>
                            <input type="text" name="ruangan" id="ruangan" class="form-control" placeholder="Contoh: R.201 / Lab Komputer" required>
                        </div>

                        <div class="mb-3">
                            <label for="tahun_ajaran" class="form-label">Tahun Ajaran</label>
                            <input type="text" name="tahun_ajaran" id="tahun_ajaran" class="form-control" placeholder="Contoh: 2024/2025" required>
                        </div>

                        <div class="mb-3">
                            <label for="semester" class="form-label">Semester</label>
                            <select name="semester" id="semester" class="form-control" required>
                                <option value="">-- Pilih Semester --</option>
                                <option value="Ganjil">Ganjil</option>
                                <option value="Genap">Genap</option>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-success mt-3">
                            <i class="fas fa-save"></i> Simpan Jadwal
                        </button>
                        <a href="data_jadwal.php" class="btn btn-secondary mt-3">
                            <i class="fas fa-arrow-left"></i> Batal
                        </a>
                    </form>
                </div>
            </div>
        </div>
    </main>
</div>
