<?php
session_start();
require_once "../config.php";

// Cek login admin //
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    echo "<script>alert('Silakan login sebagai admin'); window.location='../guest.php';</script>";
    exit;
}

require_once "template/header.php";
require_once "template/side-bar.php";
require_once "template/navbar.php";

// Inisialisasi notifikasi //
$success = false;
$error = "";

// Ambil semua data guru //
$guru_result = mysqli_query($conn, "SELECT id_guru, nip, nama_guru FROM guru"); //

// Proses submit form //
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $kode       = mysqli_real_escape_string($conn, $_POST['kode_matapelajaran'] ?? '');
    $nama       = mysqli_real_escape_string($conn, $_POST['nama_matapelajaran'] ?? '');
    $deskripsi  = mysqli_real_escape_string($conn, $_POST['deskripsi'] ?? '');
    $tingkat    = mysqli_real_escape_string($conn, $_POST['tingkat_kelas'] ?? '');
    $program    = mysqli_real_escape_string($conn, $_POST['program_pendidikan'] ?? '');
    $semester   = mysqli_real_escape_string($conn, $_POST['semester'] ?? '');
    $jumlah_jam = mysqli_real_escape_string($conn, $_POST['jumlah_jam'] ?? '');
    $id_guru    = mysqli_real_escape_string($conn, $_POST['id_guru'] ?? '');

    // Validasi //
    if (
        !empty($kode) && !empty($nama) && !empty($tingkat) &&
        !empty($program) && !empty($semester) && !empty($jumlah_jam) && !empty($id_guru)
    ) {
        $nama_guru = '';
        $result = mysqli_query($conn, "SELECT nama_guru FROM guru WHERE id_guru = '$id_guru'");
        if ($row = mysqli_fetch_assoc($result)) {
            $nama_guru = mysqli_real_escape_string($conn, $row['nama_guru']);
        }

        // Simpan ke database //
        $query = "INSERT INTO matapelajaran 
            (kode_matapelajaran, nama_matapelajaran, deskripsi, tingkat_kelas, program_pendidikan, semester, jumlah_jam, id_guru, nama_guru) 
            VALUES 
            ('$kode', '$nama', '$deskripsi', '$tingkat', '$program', '$semester', '$jumlah_jam', '$id_guru', '$nama_guru')";

        if (mysqli_query($conn, $query)) {
            $success = true;
        } else {
            $error = mysqli_error($conn);
        }
    } else {
        $error = "Semua field wajib diisi, termasuk guru pengampu.";
    }
}
?>

<!-- Tambahkan SweetAlert2 CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> <!-- // -->

<?php if ($success): ?>
<script>
    Swal.fire({
        icon: 'success',
        title: 'Berhasil!',
        text: 'Data matapelajaran berhasil disimpan.',
        showConfirmButton: false,
        timer: 2000
    }).then(() => {
        window.location.href = 'data_mapel.php';
    });
</script>
<?php elseif ($error): ?>
<div class="alert alert-danger alert-dismissible fade show mx-4 mt-3" role="alert"> <!-- // -->
    <?= htmlspecialchars($error) ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
<?php endif; ?>

<!-- Mulai konten utama -->
<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4"> <!-- // Tidak perlu container tambahan -->
            <h1 class="mt-4">Tambah MataPelajaran</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item"><a href="<?= $main_url ?>/admin/index.php">Home</a></li>
                <li class="breadcrumb-item active">Tambah MataPelajaran</li>
            </ol>

            <div class="card mb-4">
                <div class="card-body">
                    <form method="post"> <!-- // -->
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Kode Matapelajaran</label>
                                <input type="text" name="kode_matapelajaran" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Nama Matapelajaran</label>
                                <input type="text" name="nama_matapelajaran" class="form-control" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Deskripsi</label>
                            <textarea name="deskripsi" class="form-control" rows="3"></textarea>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label class="form-label">Tingkat Kelas</label>
                                <select name="tingkat_kelas" class="form-select" required>
                                    <option value="">-- Pilih --</option>
                                    <option value="VII">VII</option>
                                    <option value="VIII">VIII</option>
                                    <option value="IX">IX</option>
                                    <option value="X">X</option>
                                    <option value="XI">XI</option>
                                    <option value="XII">XII</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Program Pendidikan</label>
                                <select name="program_pendidikan" class="form-select" required>
                                    <option value="">-- Pilih --</option>
                                    <option value="Tahfidz">Tahfidz</option>
                                    <option value="Kitab Kuning">Kitab Kuning</option>
                                    <option value="Formal">Formal</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Semester</label>
                                <select name="semester" class="form-select" required>
                                    <option value="">-- Pilih --</option>
                                    <option value="Ganjil">Ganjil</option>
                                    <option value="Genap">Genap</option>
                                </select>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label class="form-label">Jumlah Jam</label>
                                <input type="number" name="jumlah_jam" class="form-control" required>
                            </div>
                            <div class="col-md-8">
                                <label class="form-label">Guru Pengampu</label>
                                <select name="id_guru" class="form-select" required>
                                    <option value="">-- Pilih Guru --</option>
                                    <?php while ($guru = mysqli_fetch_assoc($guru_result)) : ?>
                                        <option value="<?= $guru['id_guru'] ?>">
                                            <?= $guru['nip'] . ' - ' . $guru['nama_guru'] ?>
                                        </option>
                                    <?php endwhile; ?>
                                </select>
                            </div>
                        </div>

                        <div class="d-grid mt-4"> <!-- Tombol penuh -->
                            <button type="submit" class="btn btn-primary w-100">Simpan</button> <!-- // -->
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>
</div>
