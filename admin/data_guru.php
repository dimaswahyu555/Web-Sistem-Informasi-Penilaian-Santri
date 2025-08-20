<?php
session_start();
require_once "../config.php";

// Periksa apakah user sudah login dan role-nya admin
if (!isset($_SESSION['username']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    echo "<script>alert('Silakan login sebagai admin'); window.location='../guest.php';</script>";
    exit;
}


// Proses Hapus Data Guru
if (isset($_GET['id']) && isset($_GET['action']) && $_GET['action'] == 'delete') {
    $id_guru = $_GET['id'];

    $delete_query = "DELETE FROM guru WHERE id_guru = ?";
    $stmt = $conn->prepare($delete_query);
    $stmt->bind_param("i", $id_guru);

    if ($stmt->execute()) {
        echo "<script>alert('Data guru berhasil dihapus!');</script>";
    } else {
        echo "<script>alert('Gagal menghapus data guru!');</script>";
    }
    $stmt->close();

    // Redirect setelah menghapus
    header("Location: data_guru.php");
    exit;
}

// Paginasi dan query data guru tetap sama seperti sebelumnya

// Paginasi
$limit = 10;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Hitung total data guru
$total_data_query = "SELECT COUNT(*) AS total FROM guru";
$total_data_result = mysqli_query($conn, $total_data_query);
$total_data = mysqli_fetch_assoc($total_data_result)['total'] ?? 0;
$total_pages = ceil($total_data / $limit);

// Ambil data guru dengan batas paginasi
$query = "SELECT id_guru, nama_guru, nip, mata_pelajaran, alamat, jenis_kelamin, no_hp, email, tanggal_bergabung
          FROM guru 
          LIMIT $offset, $limit";
$result = mysqli_query($conn, $query);

// Include tampilan
require_once "template/header.php";
require_once "template/navbar.php";
require_once "template/side-bar.php";
?>

<!-- Main Content -->
<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">Data Guru</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item"><a href="<?= $main_url ?>/admin/index.php">Home</a></li>
                <li class="breadcrumb-item active">Data Guru</li>
            </ol>

            <div class="card shadow-lg rounded-4">
                <div class="card-header bg-dark text-white">
                    <i class="fas fa-table"></i> Daftar Data Guru Lengkap
                </div>
                <div class="card-body p-4">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Nama Guru</th>
                                    <th>NIP</th>
                                    <th>Mata Pelajaran</th>
                                    <th>Alamat</th>
                                    <th>Jenis Kelamin</th>
                                    <th>Telepon</th>
                                    <th>Email</th>
                                    <th>Tanggal Bergabung</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if ($result && mysqli_num_rows($result) > 0): ?>
                                    <?php $no = $offset + 1; ?>
                                    <?php while ($row = mysqli_fetch_assoc($result)): ?>
                                        <tr>
                                            <td><?= $no++; ?></td>
                                            <td><?= htmlspecialchars($row['nama_guru']); ?></td>
                                            <td><?= htmlspecialchars($row['nip']); ?></td>
                                            <td><?= htmlspecialchars($row['mata_pelajaran']); ?></td>
                                            <td><?= htmlspecialchars($row['alamat']); ?></td>
                                            <td><?= htmlspecialchars($row['jenis_kelamin']); ?></td>
                                            <td><?= htmlspecialchars($row['no_hp']); ?></td>
                                            <td><?= htmlspecialchars($row['email']); ?></td>
                                            <td><?= htmlspecialchars($row['tanggal_bergabung']); ?></td>
                                            <td>
                                                <a href="?id=<?= $row['id_guru']; ?>&action=delete" class="btn btn-sm btn-danger"
                                                   onclick="return confirm('Yakin ingin menghapus data ini?')">Hapus</a>
                                            </td>
                                        </tr>
                                    <?php endwhile; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="10" class="text-center">Data tidak ditemukan</td>
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
