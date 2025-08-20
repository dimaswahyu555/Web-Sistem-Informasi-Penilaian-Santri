<?php
session_start();
require_once "../config.php";

// Periksa apakah user sudah login dan role-nya admin
if (!isset($_SESSION['username']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    echo "<script>alert('Silakan login sebagai admin'); window.location='../guest.php';</script>";
    exit;
}
require_once "../config.php";
require_once "template/header.php";
require_once "template/side-bar.php";
require_once "template/navbar.php";
?>

<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid p-3">
             <h1 class="mt-4">Data MataPelajaran</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item"><a href="<?= $main_url ?>/admin/index.php">Home</a></li>
                <li class="breadcrumb-item active">Data MataPelajaran</li>
            </ol>

            <div class="card shadow-sm">
                <div class="card-body">
                    <a href="tambah_mapel.php" class="btn btn-primary mb-3">
                        <i class="fas fa-plus"></i> Tambah Mata Pelajaran
                    </a>

                    <div class="table-responsive">
                        <table class="table table-bordered table-striped" id="datatablesSimple">
                            <thead class="table-dark">
                                <tr class="text-center">
                                    <th>No</th>
                                    <th>Kode</th>
                                    <th>Nama Mapel</th>
                                    <th>Deskripsi</th>
                                    <th>Tingkat Kelas</th>
                                    <th>Program Pendidikan</th>
                                    <th>Semester</th>
                                    <th>Jumlah Jam</th>
                                    <th>Guru Pengajar</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = 1;
                                $query = mysqli_query($conn, "
                                    SELECT m.*, g.nama_guru 
                                    FROM matapelajaran m
                                    LEFT JOIN guru g ON m.id_guru = g.id_guru
                                    ORDER BY m.id_matapelajaran ASC
                                ");

                                while ($row = mysqli_fetch_assoc($query)) {
                                    $status = strtolower(trim($row['status_aktif']));
                                    $isAktif = ($status == '1' || $status == 'aktif');
                                ?>
                                    <tr>
                                        <td class="text-center"><?= $no++; ?></td>
                                        <td><?= htmlspecialchars($row['kode_matapelajaran'] ?? '-'); ?></td>
                                        <td><?= htmlspecialchars($row['nama_matapelajaran'] ?? '-'); ?></td>
                                        <td><?= nl2br(htmlspecialchars($row['deskripsi'] ?? '-')); ?></td>
                                        <td class="text-center"><?= htmlspecialchars($row['tingkat_kelas'] ?? '-'); ?></td>
                                        <td><?= htmlspecialchars($row['program_pendidikan'] ?? '-'); ?></td>
                                        <td class="text-center"><?= htmlspecialchars($row['semester'] ?? '-'); ?></td>
                                        <td class="text-center"><?= htmlspecialchars($row['jumlah_jam'] ?? '0'); ?> Jam</td>
                                        <td><?= htmlspecialchars($row['nama_guru'] ?? '-'); ?></td>
                                        <td class="text-center">
                                            <?php if ($isAktif): ?>
                                                <span class="badge bg-success">Aktif</span>
                                            <?php else: ?>
                                                <span class="badge bg-danger">Nonaktif</span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="text-center">
                                            <a href="hapus_mapel.php?id=<?= $row['id_matapelajaran']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus?');">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php } ?>

                                <?php if (mysqli_num_rows($query) == 0): ?>
                                    <tr>
                                        <td colspan="11" class="text-center">Belum ada data mata pelajaran.</td>
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
