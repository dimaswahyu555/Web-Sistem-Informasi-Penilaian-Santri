<?php
require_once "../config.php";
session_start();

// Cek login guru
if (!isset($_SESSION['id_guru'])) {
    header("Location: ../guest.php");
    exit;
}

$id_guru = $_SESSION['id_guru'];

// Proses Hapus Data Nilai
if (isset($_GET['id']) && $_GET['action'] == 'delete') {
    $id_nilai = $_GET['id'];
    $delete = $conn->prepare("
        DELETE n FROM nilai n
        JOIN matapelajaran m ON n.mapel = m.nama_matapelajaran
        WHERE n.id_nilai = ? AND m.id_guru = ?
    ");
    $delete->bind_param("ii", $id_nilai, $id_guru);
    if ($delete->execute()) {
        echo "<script>alert('Data nilai berhasil dihapus!');</script>";
    } else {
        echo "<script>alert('Gagal menghapus data nilai!');</script>";
    }
    header("Location: data_nilai.php");
    exit;
}

// Paginasi
$limit = 10;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Hitung total data
$total_result = mysqli_query($conn, "
    SELECT COUNT(*) AS total 
    FROM nilai n
    JOIN matapelajaran m ON n.mapel = m.nama_matapelajaran
    WHERE m.id_guru = $id_guru
");
$total_data = mysqli_fetch_assoc($total_result)['total'] ?? 0;
$total_pages = ceil($total_data / $limit);

// Ambil data nilai untuk guru ini
$query = "
    SELECT 
        n.*, 
        s.nama_santri
    FROM nilai n
    LEFT JOIN santri s ON n.id_santri = s.id_santri
    JOIN matapelajaran m ON n.mapel = m.nama_matapelajaran
    WHERE m.id_guru = $id_guru
    ORDER BY n.tanggal_input DESC
    LIMIT $offset, $limit
";
$result = mysqli_query($conn, $query);

require_once "./template_guru/header.php";
require_once "./template_guru/navbar.php";
require_once "./template_guru/side-bar.php";
?>

<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">Data Nilai Santri</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item"><a href="<?= $main_url ?>/guru/index.php">Home</a></li>
                <li class="breadcrumb-item active">Data Nilai</li>
            </ol>

            <div class="card shadow-lg rounded-4">
                <div class="card-header bg-dark text-white">
                    <i class="fas fa-table"></i> Daftar Nilai Santri
                </div>
                <div class="card-body p-4">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Santri</th>
                                    <th>Mata Pelajaran</th>
                                    <th>Semester</th>
                                    <th>Tahun Ajaran</th>
                                    <th>Tugas</th>
                                    <th>UTS</th>
                                    <th>UAS</th>
                                    <th>Hafalan</th>
                                    <th>Nilai Akhir</th>
                                    <th>Keterangan</th>
                                    <th>Tanggal Input</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if ($result && mysqli_num_rows($result) > 0): ?>
                                    <?php $no = $offset + 1; ?>
                                    <?php while ($row = mysqli_fetch_assoc($result)): ?>
                                        <tr>
                                            <td><?= $no++; ?></td>
                                            <td><?= htmlspecialchars($row['nama_santri'] ?? '-'); ?></td>
                                            <td><?= htmlspecialchars($row['mapel'] ?? '-'); ?></td>
                                            <td><?= htmlspecialchars($row['semester'] ?? '-'); ?></td>
                                            <td><?= htmlspecialchars($row['tahun_ajaran'] ?? '-'); ?></td>
                                            <td><?= $row['nilai_tugas']; ?></td>
                                            <td><?= $row['nilai_uts']; ?></td>
                                            <td><?= $row['nilai_uas']; ?></td>
                                            <td><?= $row['nilai_hafalan']; ?></td>
                                            <td><?= $row['nilai_akhir']; ?></td>
                                            <td><?= htmlspecialchars($row['keterangan'] ?? '-'); ?></td>
                                            <td><?= $row['tanggal_input']; ?></td>
                                            <td>
                                                <a href="?id=<?= $row['id_nilai']; ?>&action=delete" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus data ini?')">Hapus</a>
                                            </td>
                                        </tr>
                                    <?php endwhile; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="13" class="text-center">Data tidak ditemukan</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <nav>
                        <ul class="pagination justify-content-center">
                            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                                <li class="page-item <?= ($i == $page) ? 'active' : ''; ?>">
                                    <a class="page-link" href="?page=<?= $i; ?>"><?= $i; ?></a>
                                </li>
                            <?php endfor; ?>
                        </ul>
                    </nav>

                </div>
            </div>
        </div>
    </main>
</div>

<?php $conn->close(); ?>
