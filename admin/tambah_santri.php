<?php
session_start();
require_once "../config.php";

// Periksa apakah user sudah login dan role-nya admin
if (!isset($_SESSION['username']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    echo "<script>alert('Silakan login sebagai admin'); window.location='../guest.php';</script>";
    exit;
}
require_once "template/header.php"; 
require_once "template/navbar.php";
require_once "template/side-bar.php";

// Cek status untuk ditampilkan dalam modal
$status = isset($_GET['status']) ? $_GET['status'] : '';
?>

<!-- Modal Bootstrap untuk Alert Status -->
<div class="modal fade" id="statusModal" tabindex="-1" aria-labelledby="statusModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content shadow-lg rounded-4">
      <div class="modal-header bg-light">
        <h5 class="modal-title text-dark fw-bold" id="statusModalLabel">
          <?php if ($status == 'success') { echo 'Berhasil!'; } else { echo 'Gagal!'; } ?>
        </h5>
      </div>
      <div class="modal-body text-center">
        <?php if ($status == 'success') { ?>
          <i class="fas fa-check-circle text-success" style="font-size: 60px;"></i>
          <p class="mt-3 fs-5">Data santri berhasil ditambahkan!</p>
        <?php } elseif ($status == 'error') { ?>
          <i class="fas fa-exclamation-circle text-danger" style="font-size: 60px;"></i>
          <p class="mt-3 fs-5">Terjadi kesalahan saat menyimpan data santri!</p>
        <?php } ?>
      </div>
      <div class="modal-footer justify-content-center">
        <button type="button" class="btn btn-primary px-4" data-bs-dismiss="modal">OK</button>
      </div>
    </div>
  </div>
</div>

<script>
  <?php if (!empty($status)) { ?>
    var myModal = new bootstrap.Modal(document.getElementById('statusModal'), {
      backdrop: 'static'
    });
    myModal.show();
  <?php } ?>
</script>

<!-- Main Content -->
<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">Tambah Santri</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item"><a href="/ppinayatullah2/admin/index.php">Home</a></li>
                <li class="breadcrumb-item active">Tambah Santri</li>
            </ol>

            <!-- Form Tambah Santri -->
            <div class="card shadow-lg rounded-4">
                <div class="card-header bg-dark text-white">
                    <i class="fas fa-user-plus"></i> Form Tambah Santri
                </div>
                <div class="card-body p-4">
                    <form action="./proses-user/proses-tambah-santri.php" method="POST" enctype="multipart/form-data">
                        <div class="row">
                            <!-- Kolom Kiri -->
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="username" class="form-label">Username</label>
                                    <input type="text" class="form-control" id="username" name="username" placeholder="Masukkan username" required>
                                </div>
                                <div class="mb-3">
                                    <label for="nama_santri" class="form-label">Nama Santri</label>
                                    <input type="text" class="form-control" id="nama_santri" name="nama_santri" placeholder="Masukkan nama lengkap" required>
                                </div>
                                <div class="mb-3">
                                    <label for="nisn" class="form-label">NISN</label>
                                    <input type="text" class="form-control" id="nisn" name="nisn" placeholder="Masukkan NISN" required>
                                </div>
                                <div class="mb-3">
                                    <label for="tempat_lahir" class="form-label">Tempat Lahir</label>
                                    <input type="text" class="form-control" id="tempat_lahir" name="tempat_lahir" placeholder="Masukkan tempat lahir" required>
                                </div>
                                <div class="mb-3">
                                    <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
                                    <input type="date" class="form-control" id="tanggal_lahir" name="tanggal_lahir" required>
                                </div>
                                <div class="mb-3">
                                    <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                                    <select class="form-select" id="jenis_kelamin" name="jenis_kelamin" required>
                                        <option value="" selected disabled>Pilih Jenis Kelamin</option>
                                        <option value="Laki-laki">Laki-laki</option>
                                        <option value="Perempuan">Perempuan</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="alamat" class="form-label">Alamat</label>
                                    <textarea class="form-control" id="alamat" name="alamat" rows="2" placeholder="Masukkan alamat lengkap" required></textarea>
                                </div>
                            </div>

                            <!-- Kolom Kanan -->
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="no_hp" class="form-label">No Telepon Wali</label>
                                    <input type="text" class="form-control" id="no_hp" name="no_hp" placeholder="Masukkan nomor HP" required>
                                </div>
                                <div class="mb-3">
                                    <label for="nama_wali_santri" class="form-label">Nama Wali Santri</label>
                                    <input type="text" class="form-control" id="nama_wali_santri" name="nama_wali_santri" placeholder="Masukkan nama wali santri" required>
                                </div>
                                <div class="mb-3">
                                    <label for="kelas" class="form-label">Kelas</label>
                                    <input type="text" class="form-control" id="kelas" name="kelas" placeholder="Masukkan kelas" required>
                                </div>
                                <div class="mb-3">
                                    <label for="program_pendidikan" class="form-label">Program Pendidikan</label>
                                    <input type="text" class="form-control" id="program_pendidikan" name="program_pendidikan" placeholder="Masukkan program pendidikan" required>
                                </div>
                                <div class="mb-3">
                                    <label for="tanggal_bergabung" class="form-label">Tanggal Daftar</label>
                                    <input type="date" class="form-control" id="tanggal_bergabung" name="tanggal_bergabung" required>
                                </div>
                            </div>

                            <div class="col-md-12 text-center mt-3">
                                <img src="../image/default-user.png" alt="Foto User" class="rounded-circle shadow-sm mb-3" width="120px">
                                <div class="mb-2">
                                    <input type="file" name="image" class="form-control form-control-sm" accept="image/png, image/jpg, image/jpeg">
                                </div>
                                <small class="text-muted">Pilih foto dalam format PNG, JPG, atau JPEG.</small>
                            </div>
                        </div>

                        <div class="text-center mt-4">
                            <button type="submit" class="btn btn-primary px-4">Tambah Santri</button>
                            <button type="reset" class="btn btn-secondary px-4">Reset</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>
</div>
