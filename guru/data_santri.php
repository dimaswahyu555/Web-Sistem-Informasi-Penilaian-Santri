<?php
require_once "../config.php";  // Koneksi ke database

// Proses Hapus Data Santri
if (isset($_GET['id']) && isset($_GET['action']) && $_GET['action'] == 'delete') {
    $id_santri = $_GET['id'];

    // Query DELETE berdasarkan id_santri
    $delete_query = "DELETE FROM santri WHERE id_santri = ?";
    $stmt = $conn->prepare($delete_query);
    $stmt->bind_param("i", $id_santri);

    if ($stmt->execute()) {
        echo "<script>alert('Data santri berhasil dihapus!');</script>";
    } else {
        echo "<script>alert('Gagal menghapus data santri!');</script>";
    }
    $stmt->close();

    // Redirect kembali ke halaman data_santri.php setelah penghapusan
    header("Location: data_santri.php");
    exit;
}

// Definisikan batas data per halaman untuk paginasi
$limit = 10;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Hitung total data untuk paginasi
$total_data_query = "SELECT COUNT(*) AS total FROM santri";
$total_data_result = mysqli_query($conn, $total_data_query);
$total_data = mysqli_fetch_assoc($total_data_result)['total'] ?? 0;
$total_pages = ceil($total_data / $limit);

// Ambil data santri lengkap dengan paginasi
$query = "SELECT id_santri, nama_santri, nisn, tanggal_lahir, alamat, jenis_kelamin, no_telepon_wali, 
                 nama_wali_santri, kelas, program_pendidikan, foto, tanggal_daftar 
          FROM santri 
          LIMIT $offset, $limit";
$result = mysqli_query($conn, $query);

require_once "./template_guru/header.php";
require_once "./template_guru/navbar.php";
require_once "./template_guru/side-bar.php";
?>

<!-- Main Content -->
<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">Data Santri</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item"><a href="<?= $main_url ?>/guru/index.php">Home</a></li>
                <li class="breadcrumb-item active">Data Santri</li>
            </ol>

            <div class="card shadow-lg rounded-4">
                <div class="card-header bg-dark text-white">
                    <i class="fas fa-table"></i> Daftar Data Santri Lengkap
                </div>
                <div class="card-body p-4">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Nama Santri</th>
                                    <th>Tanggal Lahir</th>
                                    <th>Alamat</th>
                                    <th>Jenis Kelamin</th>
                                    <th>Nama Wali</th>
                                    <th>Telepon Wali</th>
                                    <th>Kelas</th>
                                    <th>Program Pendidikan</th>
                                    <th>Tanggal Daftar</th>
                                    <th>Foto</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if ($result && mysqli_num_rows($result) > 0): ?>
                                    <?php $no = $offset + 1; ?>
                                    <?php while ($row = mysqli_fetch_assoc($result)): ?>
                                        <tr>
                                            <td><?= $no++; ?></td>
                                            <td><?= htmlspecialchars($row['nama_santri'] ?? 'Tidak tersedia'); ?></td>
                                            <td><?= htmlspecialchars($row['tanggal_lahir'] ?? 'Tidak tersedia'); ?></td>
                                            <td><?= htmlspecialchars($row['alamat'] ?? 'Tidak tersedia'); ?></td>
                                            <td><?= htmlspecialchars($row['jenis_kelamin'] ?? 'Tidak tersedia'); ?></td>
                                            <td><?= htmlspecialchars($row['nama_wali_santri'] ?? 'Tidak tersedia'); ?></td>
                                            <td><?= htmlspecialchars($row['no_telepon_wali'] ?? 'Tidak tersedia'); ?></td>
                                            <td><?= htmlspecialchars($row['kelas'] ?? 'Tidak tersedia'); ?></td>
                                            <td><?= htmlspecialchars($row['program_pendidikan'] ?? 'Tidak tersedia'); ?></td>
                                            <td><?= htmlspecialchars($row['tanggal_daftar'] ?? 'Tidak tersedia'); ?></td>
                                            <td>
                                                <img src="path/to/foto/<?= htmlspecialchars($row['foto']); ?>" alt="Foto Santri" width="50">
                                            </td>
                                            <td>
                                                <a href="edit_santri.php?id=<?= $row['id_santri']; ?>" class="btn btn-sm btn-warning">Edit</a>
                                                <a href="?id=<?= $row['id_santri']; ?>&action=delete" class="btn btn-sm btn-danger" 
                                                   onclick="return confirm('Yakin ingin menghapus data ini?')">Hapus</a>
                                            </td>
                                        </tr>
                                    <?php endwhile; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="12" class="text-center">Data tidak ditemukan</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <nav aria-label="Page navigation example">
                        <ul class="pagination justify-content-center">
                            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                                <li class="page-item <?= $page == $i ? 'active' : ''; ?>">
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

<?php
if (isset($conn) && $conn !== null) {
    $conn->close();
}
?>
