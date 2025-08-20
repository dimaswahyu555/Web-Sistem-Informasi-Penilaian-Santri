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
          <p class="mt-3 fs-5">Data Guru berhasil ditambahkan!</p>
        <?php } elseif ($status == 'error') { ?>
          <i class="fas fa-exclamation-circle text-danger" style="font-size: 60px;"></i>
          <p class="mt-3 fs-5">Terjadi kesalahan saat menyimpan data Guru!</p>
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
            <h1 class="mt-4">Tambah Guru</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item"><a href="<?= $main_url ?>/admin/index.php">Home</a></li>
                <li class="breadcrumb-item active">Tambah Guru</li>
            </ol>

            <div class="card shadow-lg rounded-4">
                <div class="card-header bg-dark text-white">
                    <i class="fas fa-user-plus"></i> Form Tambah Guru
                </div>
                <div class="card-body p-4">
                    <form action="./proses-user/proses-tambah-guru.php" method="POST" enctype="multipart/form-data">
                        <div class="row">
                            <!-- Kolom Kiri -->
                            <div class="col-md-6">
                                <!-- Form Inputs -->
                                <div class="mb-3">
                                    <label for="username" class="form-label">Username</label>
                                    <input type="text" class="form-control" id="username" name="username" placeholder="Masukkan username" required>
                                </div>

                                <div class="mb-3">
                                    <label for="nama_guru" class="form-label">Nama Guru</label>
                                    <input type="text" class="form-control" id="nama_guru" name="nama_guru" placeholder="Masukkan nama lengkap" required>
                                </div>
                                <div class="mb-3">
                                      <label for="nip" class="form-label">NIP</label>
                                        <input type="text" class="form-control" id="nip" name="nip" placeholder="Masukkan NIP" required>
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
                                <!-- Form Inputs -->
                                <div class="mb-3">
                                    <label for="no_hp" class="form-label">No Handphone</label>
                                    <input type="text" class="form-control" id="no_hp" name="no_hp" placeholder="Masukkan nomor HP" required>
                                </div>

                                <div class="mb-3">
                                    <label for="email" class="form-label">E-Mail</label>
                                    <input type="email" class="form-control" id="email" name="email" placeholder="Masukkan email" required>
                                </div>

                                <div class="mb-3">
                                    <label for="mata_pelajaran" class="form-label">Mata Pelajaran</label>
                                    <input type="text" class="form-control" id="mata_pelajaran" name="mata_pelajaran" placeholder="Masukkan mata pelajaran yang diajarkan" required>
                                </div>

                                <div class="mb-3">
                                    <label for="pendidikan" class="form-label">Pendidikan Terakhir</label>
                                    <input type="text" class="form-control" id="pendidikan" name="pendidikan" placeholder="Masukkan pendidikan terakhir" required>
                                </div>

                                <div class="mb-3">
                                    <label for="status_aktif" class="form-label">Status Aktif</label>
                                    <select class="form-select" id="status_aktif" name="status_aktif" required>
                                        <option value="" selected disabled>Pilih Status</option>
                                        <option value="Aktif">Aktif</option>
                                        <option value="Tidak Aktif">Tidak Aktif</option>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label for="tanggal_bergabung" class="form-label">Tanggal Bergabung</label>
                                    <input type="date" class="form-control" id="tanggal_bergabung" name="tanggal_bergabung" required>
                                </div>
                            </div>

                            <div class="text-center mt-4">
                                <button type="submit" class="btn btn-primary px-4">Tambah Guru</button>
                                <button type="reset" class="btn btn-secondary px-4">Reset</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>
</div>
